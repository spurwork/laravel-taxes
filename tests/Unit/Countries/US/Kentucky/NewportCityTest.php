<?php

namespace Appleton\Taxes\Countries\US\Kentucky\NewportCity;

use Appleton\Taxes\Countries\US\Kentucky\NewportCity\NewportCity;
use Carbon\Carbon;

class NewportCityTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNewportCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.newport_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.newport_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(NewportCity::class));
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
                7.5,
            ],
            '2' => [
                'January 1, 2019 8am',
                900,
                132000,
                22.5,
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