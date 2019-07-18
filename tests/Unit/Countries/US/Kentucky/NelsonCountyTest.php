<?php

namespace Appleton\Taxes\Countries\US\Kentucky\NelsonCounty;

use Appleton\Taxes\Countries\US\Kentucky\NelsonCounty\NelsonCounty;
use Carbon\Carbon;

class NelsonCountyTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNelsonCounty($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.nelson_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.nelson_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(NelsonCounty::class));
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
                1.5,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                14100,
                4.5,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                15000,
                null,
            ],
        ];
    }
}
