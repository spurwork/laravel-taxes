<?php

namespace Appleton\Taxes\Countries\US\Kentucky\McLeanCounty;

use Appleton\Taxes\Countries\US\Kentucky\McLeanCounty\McLeanCounty;
use Carbon\Carbon;

class McLeanCountyTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testMcLeanCounty($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.mclean_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.mclean_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(McLeanCounty::class));
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
                49100,
                9.0,
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
