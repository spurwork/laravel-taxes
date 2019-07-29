<?php

namespace Appleton\Taxes\Countries\US\Kentucky\RussellCounty;

use Appleton\Taxes\Countries\US\Kentucky\RussellCounty\RussellCounty;
use Carbon\Carbon;

class RussellCountyTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testRussellCounty($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.russell_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.russell_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(RussellCounty::class));
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
                2.25,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                32433.33,
                6.75,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                33333.33,
                null,
            ],
        ];
    }
}
