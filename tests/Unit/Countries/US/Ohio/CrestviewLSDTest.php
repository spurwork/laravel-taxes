<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\CrestviewLSD;

use Appleton\Taxes\Countries\US\Ohio\CrestviewLSD\CrestviewLSDTax;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class CrestviewLSDTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testCrestviewLSD($date, $exempt, $dependents, $school_district_id, $earnings, $result)
    {
        OhioIncomeTaxInformation::forUser($this->user)->update([
            'dependents' => $dependents,
            'exempt' => $exempt,
            'school_district_id' => $school_district_id,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(CrestviewLSDTax::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // dependents
        // school district id
        // earnings
        // results
        return [
            // slightly different. 2 Crestviews with different school district id's (1503 and 8101) but are the same tax rate.
            // exempt
            '0' => [
                'January 1, 2019 8am',
                true,
                0,
                '1503',
                50,
                null,
            ],
            // no depedents, traditional
            '1' => [
                'January 1, 2019 8am',
                false,
                0,
                '1503',
                500,
                5.0,
            ],
            // 2 depedents, traditional
            '2' => [
                'January 1, 2019 8am',
                false,
                2,
                '1503',
                500,
                4.75,
            ],
             // no depedents, traditional
             '3' => [
                'January 1, 2019 8am',
                false,
                0,
                '8101',
                500,
                5.0,
            ],
            // 2 depedents, traditional
            '4' => [
                'January 1, 2019 8am',
                false,
                2,
                '8101',
                500,
                4.75,
            ],
            // not this district id, should be null
            '5' => [
                'January 1, 2019 8am',
                false,
                2,
                '2222',
                500,
                null,
            ],
        ];
    }
}
