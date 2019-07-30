<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\CumberlandCounty;
use Carbon\Carbon;
use TestCase;

class CumberlandCountyTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testCumberlandCounty($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.cumberland_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.cumberland_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(CumberlandCounty::class));
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
                3.75,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                59100,
                11.25,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                60000,
                null,
            ],
        ];
    }
}
