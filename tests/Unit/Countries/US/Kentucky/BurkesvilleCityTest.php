<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BurkesvilleCity\BurkesvilleCity;
use Carbon\Carbon;
use TestCase;

class BurkesvilleCityTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testBurkesvilleCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.burkesville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.burkesville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(BurkesvilleCity::class));
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
                6.0,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                36600,
                18.0,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                37500,
                null,
            ],
        ];
    }
}
