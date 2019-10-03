<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonTransit;

use Appleton\Taxes\Countries\US\Oregon\OregonTransit\OregonTransit;
use Carbon\Carbon;

class OregonTransitTaxTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testOregonTransitTax($date, $earnings, $home_location, $work_location, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings, $home_location, $work_location) {
            $taxes->setHomeLocation($this->getLocation($home_location));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
        });

        $this->assertSame($result, $results->getTax(OregonTransit::class));
    }

    public function provideTestData()
    {
        // date
        // earnings
        // home location
        // work location
        return [
            '0' => [
                'July 10, 2019 8am',
                0,
                'us.oregon',
                'us.oregon',
                null,
            ],
            '1' => [
                'July 10, 2019 8am',
                400,
                'us.oregon',
                'us.oregon',
                0.4,
            ],
            '2' => [
                'July 10, 2019 8am',
                930,
                'us.alabama',
                'us.oregon',
                0.93,
            ],
            '3' => [
                'July 10, 2019 8am',
                930,
                'us.oregon',
                'us.alabama',
                0.93,
            ],
            '4' => [
                'July 10, 2019 8am',
                19000,
                'us.oregon',
                'us.alabama',
                19.0,
            ],
            '5' => [
                'July 10, 2019 8am',
                1000,
                'us.alabama',
                'us.alabama',
                null,
            ],
        ];
    }
}
