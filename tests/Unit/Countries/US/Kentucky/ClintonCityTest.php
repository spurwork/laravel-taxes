<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ClintonCity\ClintonCity;
use Carbon\Carbon;
use TestCase;

class ClintonCityTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testClintonCity($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.clinton_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.clinton_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(ClintonCity::class));
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
                39100,
                4.5,
            ],
            '3' => [
                'January 1, 2019 8am',
                771,
                40000,
                null,
            ],
        ];
    }
}
