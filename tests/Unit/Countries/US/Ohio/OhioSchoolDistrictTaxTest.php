<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\OhioSchoolDistrictTax;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTax\OhioSchoolDistrictTax;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class OhioSchoolDistrictTaxTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testOhioIncome($date, $exempt, $dependents, $school_district_id, $earnings, $ytd_earnings, $result)
    {
        OhioIncomeTaxInformation::forUser($this->user)->update([
            'dependents' => $dependents,
            'exempt' => $exempt,
            'school_district_id' => $school_district_id,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings, $ytd_earnings) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(OhioSchoolDistrictTax::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // dependents
        // school district id
        // earnings
        // ytd earnings
        // results
        return [
            // No school district id
            // '0' => [
            //     'January 1, 2019 8am',
            //     false,
            //     0,
            //     null,
            //     300,
            //     null,
            // ],
            '1' => [
                'January 1, 2019 8am',
                false,
                0,
                3301,
                50,
                0,
                0.75,
            ],
            // wage base of 9500 should be null
            '2' => [
                'January 1, 2019 8am',
                false,
                0,
                2305,
                50,
                9500,
                null,
            ],
            // wage base not met
            '3' => [
                'January 1, 2019 8am',
                false,
                0,
                2305,
                50,
                0,
                0.75,
            ],
            // '2' => [
            //     'January 1, 2019 8am',
            //     false,
            //     2,
            // 	   null,
            //     300,
            //     3.32,
            // ],
            // '3' => [
            //     'January 1, 2019 8am',
            //     false,
            //     5,
            // 	   null,
            //     2000,
            //     64.86,
            // ],
            // '4' => [
            //     'January 1, 2019 8am',
            //     false,
            //     0,
            // 	   null,
            //     500,
            //     9.92,
            // ],
            // '5' => [
            //     'January 1, 2019 8am',
            //     false,
            //     2,
            // 	   null,
            //     700,
            //     15.56,
            // ],
        ];
    }
}
