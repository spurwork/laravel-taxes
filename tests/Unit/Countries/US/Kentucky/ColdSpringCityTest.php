<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ColdSpringCity\ColdSpringCity;
use Carbon\Carbon;
use TestCase;

class ColdSpringCityTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testColdSpringCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.cold_spring_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.cold_spring_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(ColdSpringCity::class));
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
                3.0,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                132000,
                9.0,
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
