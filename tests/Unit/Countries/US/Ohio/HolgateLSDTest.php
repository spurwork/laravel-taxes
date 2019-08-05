<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\HolgateLSD;

use Appleton\Taxes\Countries\US\Ohio\HolgateLSD\HolgateLSDTax;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class HolgateLSDTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testHolgateLSD($date, $exempt, $dependents, $school_district_id, $earnings, $result)
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

        $this->assertSame($result, $results->getTax(HolgateLSDTax::class));
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
            // exempt
            '0' => [
                'January 1, 2019 8am',
                true,
                0,
                '3501',
                50,
                null,
            ],
            // no depedents, traditional
            '1' => [
                'January 1, 2019 8am',
                false,
                0,
                '3501',
                500,
                7.5,
            ],
            // 2 depedents, traditional
            '2' => [
                'January 1, 2019 8am',
                false,
                2,
                '3501',
                500,
                7.13,
            ],
            // not this district id, should be null
            '3' => [
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
