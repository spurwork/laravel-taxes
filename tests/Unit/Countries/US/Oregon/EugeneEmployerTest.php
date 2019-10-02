<?php

namespace Appleton\Taxes\Unit\Countries\US\Oregon\EugeneEmployer;

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
                'January 1, 2019 8am',
                'us.oregon.eugene',
                'us.oregon.eugene',
                300,
                0.63,
            ],
            '1' => [
                'July 10, 2020 8am',
                'us.oregon.eugene',
                'us.oregon.eugene',
                300,
                0.63,
            ],
            // '2' => [
            //     'July 10, 2020 8am',
            //     'us.oregon.eugene',
            //     'us.oregon.eugene',
            //     300,
            //     8.17,
            // ],
            // '3' => [
            //     'July 10, 2020 8am',
            //     'us.oregon.eugene',
            //     'us.oregon.eugene',
            //     550,
            //     17.02,
            // ],
            // '4' => [
            //     'July 10, 2020 8am',
            //     'us.oregon.eugene',
            //     'us.oregon.eugene',
            //     153.84,
            //     4.44,
            // ],
            // '5' => [
            //     'July 10, 2020 8am',
            //     'us.oregon.eugene',
            //     'us.oregon.eugene',
            //     673.07,
            //     28.19,
            // ],
            // '6' => [
            //     'July 10, 2020 8am',
            //     'us.oregon.eugene',
            //     'us.oregon.eugene',
            //     1000,
            //     44.32,
            // ],
        ];
    }
}
