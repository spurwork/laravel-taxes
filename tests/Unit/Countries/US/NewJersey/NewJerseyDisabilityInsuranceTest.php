<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\NewJerseyDisabilityInsurance;
use Carbon\Carbon;

class NewJerseyDisabilityInsuranceTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNewJerseyDisabilityInsurance($date, $wtd_earnings, $earnings, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($wtd_earnings, $earnings) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setWtdEarnings($wtd_earnings);
            $taxes->setEarnings($earnings);
        });

        $this->assertSame($result, $results->getTax(NewJerseyDisabilityInsurance::class));
    }

    public function provideTestData()
    {
        return [
            '0' => [
                'January 1, 2019 8am',
                0,
                0,
                0.0,
            ],
            '1' => [
                'January 1, 2019 8am',
                400,
                23345,
                0.68,
            ],
            '2' => [
                'January 1, 2019 8am',
                930,
                500,
                1.58,
            ],
            '3' => [
                'January 1, 2019 8am',
                930,
                34000,
                0.9, // check with Corey to see if he had a typo
            ],
        ];
    }
}
