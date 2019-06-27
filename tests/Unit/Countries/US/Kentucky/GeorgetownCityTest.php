<?php

namespace Appleton\Taxes\Countries\US\Kentucky\GeorgetownCity;

use Appleton\Taxes\Countries\US\Kentucky\GeorgetownCity\GeorgetownCity;
use Carbon\Carbon;

class GeorgetownCityTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testGeorgetownCity($date, $home_location, $work_location, $earnings, $result)
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

        $this->assertSame($result, $results->getTax(GeorgetownCity::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.georgetown_city'),
                $this->getLocation('us.kentucky.georgetown_city'),
                300,
                3.0,
            ],
        ];
    }
}
