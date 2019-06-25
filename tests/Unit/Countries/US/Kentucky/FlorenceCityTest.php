<?php

namespace Appleton\Taxes\Countries\US\Kentucky\FlorenceCity;

use Appleton\Taxes\Countries\US\Kentucky\FlorenceCity\FlorenceCity;
use Carbon\Carbon;

class FlorenceCityTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testFlorenceCity($date, $home_location, $work_location, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($home_location, $work_location, $earnings) {
            $taxes->setHomeLocation($home_location);
            $taxes->setWorkLocation($work_location);
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(FlorenceCity::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.florence_city'),
                $this->getLocation('us.kentucky.florence_city'),
                300,
                6.0,
            ],
        ];
    }
}
