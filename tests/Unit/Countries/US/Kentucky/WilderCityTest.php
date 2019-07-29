<?php

namespace Appleton\Taxes\Countries\US\Kentucky\WilderCity;

use Appleton\Taxes\Countries\US\Kentucky\WilderCity\WilderCity;
use Carbon\Carbon;

class WilderCityTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testWilderCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.wilder_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.wilder_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(WilderCity::class));
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
                6.75,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                132000,
                20.25,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                132900,
                null,
            ],
        ];
    }
}
