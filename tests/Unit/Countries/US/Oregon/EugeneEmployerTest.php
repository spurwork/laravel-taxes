<?php

namespace Appleton\Taxes\Countries\US\Oregon\EugeneEmployer;

use Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\EugeneEmployer;
use Carbon\Carbon;
use TestCase;

class EugeneEmployerTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testEugeneEmployer($date, $home_location, $work_location, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings, $home_location, $work_location) {
            $taxes->setHomeLocation($this->getLocation($home_location));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(EugeneEmployer::class));
    }

    public function provideTestData()
    {
        // date
        // home location
        // work location
        // earnings
        // results
        return [
            // before the start, should be null
            '0' => [
                'July 1, 2019 8am',
                'us.oregon.eugene',
                'us.oregon.eugene',
                300,
                null,
            ],
            '1' => [
                'July 10, 2020 8am',
                'us.oregon.eugene',
                'us.oregon.eugene',
                300,
                0.63,
            ],
            '2' => [
                'July 10, 2020 8am',
                'us.oregon.eugene',
                'us.oregon',
                300,
                null,
            ],
            '3' => [
                'July 10, 2020 8am',
                'us.oregon',
                'us.oregon',
                550,
                null,
            ],
            '4' => [
                'July 10, 2020 8am',
                'us.oregon.eugene',
                'us.oregon.eugene',
                1000,
                2.1,
            ],
        ];
    }
}
