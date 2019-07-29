<?php

namespace Appleton\Taxes\Countries\US\Kentucky\FortWrightCity;

use Appleton\Taxes\Countries\US\Kentucky\FortWrightCity\FortWrightCity;
use Carbon\Carbon;

class FortWrightCityTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testFortWrightCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.fort_wright_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.fort_wright_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(FortWrightCity::class));
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
                3.45,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                132000,
                10.35,
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
