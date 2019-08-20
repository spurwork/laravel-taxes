<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkDisabilityInsurance;

use Carbon\Carbon;

class NewYorkDisabilityInsuranceTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNewYorkDisabilityInsurance($date, $wtd_earnings, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        dump($earnings);
        $results = $this->taxes->calculate(function ($taxes) use ($wtd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setWtdEarnings($wtd_earnings);
            $taxes->setEarnings($earnings);
        });

        $this->assertSame($result, $results->getTax(NewYorkDisabilityInsurance::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                0,
                350,
                0.60,
            ],
            '1' => [
                'January 1, 2019 8am',
                0,
                1400,
                0.60,
            ],
            '2' => [
                'January 1, 2019 8am',
                (function () {
                    return 0;
                }),
                100,
                0.50,
            ],
        ];
    }
}
