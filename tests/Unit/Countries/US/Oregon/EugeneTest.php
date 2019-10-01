<?php

namespace Appleton\Taxes\Countries\US\Oregon\Eugene;

use Carbon\Carbon;
use TestCase;

class EugeneTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testEugene($date, $min_wage, $earnings, $home_location, $work_location, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings, $min_wage, $home_location, $work_location) {
            $taxes->setHomeLocation($this->getLocation($home_location));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setMinWage($min_wage);
            $taxes->setEarnings($earnings);
        });

        $this->assertSame($result, $results->getTax(Eugene::class));
    }

    public function provideTestData()
    {
        // date
        // minimum wage
        // earnings
        // home location
        // work location
        // result
        return [
            '0' => [
                'July 1, 2019 8am',
                11.25,
                350,
                'us.oregon',
                'us.oregon.eugene',
                null,
            ],
            '1' => [
                'July 1, 2020 8am',
                11.25,
                350,
                'us.oregon',
                'us.oregon.eugene',
                null,
            ],
            '2' => [
                'July 1, 2020 8am',
                11.25,
                350,
                'us.oregon.eugene',
                'us.oregon',
                null,
            ],
            '3' => [
                'July 1, 2020 8am',
                12,
                350,
                'us.oregon',
                'us.oregon.eugene',
                1.05,
            ],
            '4' => [
                'July 1, 2020 8am',
                12,
                350,
                'us.oregon.eugene',
                'us.oregon',
                null,
            ],
            '4' => [
                'July 1, 2020 8am',
                16,
                350,
                'us.oregon',
                'us.oregon.eugene',
                1.54,
            ],
            '5' => [
                'July 1, 2020 8am',
                16,
                350,
                'us.oregon.eugene',
                'us.oregon',
                null,
            ],
        ];
    }
}
