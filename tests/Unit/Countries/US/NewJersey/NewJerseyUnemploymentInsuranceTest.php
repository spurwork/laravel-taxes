<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemploymentInsurance;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemploymentInsurance\NewJerseyUnemploymentInsurance;
use Carbon\Carbon;

class NewJerseyUnemploymentInsuranceTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNewJerseyUnemploymentInsurance($date, $wtd_earnings, $earnings, $result)
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

        $this->assertSame($result, $results->getTax(NewJerseyUnemploymentInsurance::class));
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
                1.7,
            ],
            '2' => [
                'January 1, 2019 8am',
                930,
                500,
                3.95,
            ],
            '3' => [
                'January 1, 2019 8am',
                930,
                34000,
                1.70
            ],
        ];
    }
}
