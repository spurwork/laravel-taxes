<?php

namespace Appleton\Taxes\Countries\US\Kentucky\ParkHillsCity;

use Appleton\Taxes\Countries\US\Kentucky\ParkHillsCity\ParkHillsCity;
use Carbon\Carbon;

class ParkHillsCityTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testParkHillsCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.park_hills_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.park_hills_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(ParkHillsCity::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                0,
                0,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                300,
                5000,
                4.5,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                49100,
                13.5,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                50000,
                null,
            ],
        ];
    }
}
