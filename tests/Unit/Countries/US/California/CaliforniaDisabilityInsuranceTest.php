<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaDisabilityInsurance;

use Appleton\Taxes\Countries\US\California\CaliforniaDisabilityInsurance\CaliforniaDisabilityInsurance;
use Carbon\Carbon;

class CaliforniaDisabilityInsuranceTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testCaliforniaDisabilityInsurance($date, $earnings, $ytd_earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($ytd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.california'));
            $taxes->setWorkLocation($this->getLocation('us.california'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });

        $this->assertSame($result, $results->getTax(CaliforniaDisabilityInsurance::class));
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
                400,
                5000,
                4.0,
            ],
            '2' => [
                'January 1, 2019 8am',
                771,
                118000,
                3.71,
            ],
        ];
    }
}
