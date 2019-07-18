<?php

namespace Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity;

use Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity\HighlandHeightsCity;
use Carbon\Carbon;

class HighlandHeightsCityTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testHighlandHeightsCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.highland_heights_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.highland_heights_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(HighlandHeightsCity::class));
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
                99100,
                9.0,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                100000,
                null,
            ],
        ];
    }
}
