<?php

namespace Appleton\Taxes\Countries\US\Kentucky\BooneCountyOrdinance;

use Appleton\Taxes\Countries\US\Kentucky\BooneCountyOrdinance\BooneCountyOrdinance;
use Carbon\Carbon;

class BooneCountyOrdinanceTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testBooneCountyOrdinance($date, $home_location, $work_location, $earnings, $result)
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

        $this->assertSame($result, $results->getTax(BooneCountyOrdinance::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                $this->getLocation('us.kentucky.boone_county'),
                $this->getLocation('us.kentucky.boone_county'),
                300,
                2.4,
            ],
        ];
    }
}
