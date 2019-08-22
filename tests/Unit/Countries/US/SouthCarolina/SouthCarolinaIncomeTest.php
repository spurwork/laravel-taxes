<?php

namespace Appleton\Taxes\Unit\Countries\US\SouthCarolina\SouthCarolinaIncome;

use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\SouthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\SouthCarolina\SouthCarolinaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class SouthCarolinaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testSouthCarolinaIncome($date, $exempt, $exemptions, $earnings, $result)
    {
        SouthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $exemptions,
            'exempt' => $exempt,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.south_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.south_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(SouthCarolinaIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // exemptions
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                0,
                300,
                13.51,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                1,
                300,
                8.17,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                3,
                550,
                17.02,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                0,
                153.84,
                4.44,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                2,
                673.07,
                28.19,
            ],
            '6' => [
                'January 1, 2019 8am',
                false,
                4,
                1000,
                44.32,
            ],
        ];
    }
}
