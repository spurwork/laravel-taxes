<?php

namespace Appleton\Taxes\Countries\US\Arkansas\Texarkana;

use Appleton\Taxes\Countries\US\Arkansas\Texarkana\Texarkana;
use Carbon\Carbon;
use TestCase;

class TexarkanaTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testTexarkana($date, $home_location, $work_location, $earnings, $result)
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

        $this->assertSame($result, $results->getTax(Texarkana::class));
    }

    public function provideTestData()
    {
        // date
        // home location
        // work location
        // earnings
        // results
        return [
            '0' => [
                'July 1, 2019 8am',
                'us.arkansas.texarkana',
                'us.arkansas.texarkana',
                300,
                null,
            ],
            '1' => [
                'July 10, 2020 8am',
                'us.arkansas.texarkana',
                'us.arkansas.texarkana',
                300,
                null,
            ],
            '2' => [
                'July 10, 2020 8am',
                'us.arkansas',
                'us.arkansas',
                300,
                null,
            ],
            '3' => [
                'July 10, 2020 8am',
                'us.texas',
                'us.arkansas.texarkana',
                550,
                null,
            ],
            '4' => [
                'July 10, 2020 8am',
                'us.arkansas.texarkana',
                'us.texas',
                1000,
                null,
            ],
        ];
    }
}
