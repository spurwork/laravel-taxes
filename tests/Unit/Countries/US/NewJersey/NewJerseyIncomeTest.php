<?php

namespace Appleton\Taxes\Unit\Countries\US\NewJersey\NewJerseyIncome;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome;
use Appleton\Taxes\Models\Countries\US\NewJersey\NewJerseyIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class NewJerseyIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testNewJerseyIncome($date, $filing_status, $exempt, $exemptions, $earnings, $result)
    {
        NewJerseyIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'exempt' => $exempt,
            'exemptions' => $exemptions,
            'filing_status' => $filing_status,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );


        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(NewJerseyIncome::class));
    }

    public function provideTestData()
    {
        return [
            // '0' => [
            //     'January 1, 2019 8am',
            //     NewJerseyIncome::FILING_SINGLE,
            //     false,
            //     0,
            //     300,
            //     4.5,
            // ],
            // '1' => [
            //     'January 1, 2019 8am',
            //     NewJerseyIncome::FILING_SINGLE,
            //     true,
            //     0,
            //     300,
            //     0.0,
            // ],
            // '2' => [
            //     'January 1, 2019 8am',
            //     NewJerseyIncome::FILING_SINGLE,
            //     false,
            //     0,
            //     600,
            //     10.07,
            // ],
            // '3' => [
            //     'January 1, 2019 8am',
            //     NewJerseyIncome::FILING_SINGLE,
            //     false,
            //     2,
            //     1500,
            //     57.69,
            // ],
            // '4' => [
            //     'January 1, 2019 8am',
            //     NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
            //     false,
            //     0,
            //     300,
            //     4.5,
            // ],
            // '5' => [
            //     'January 1, 2019 8am',
            //     NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
            //     false,
            //     0,
            //     600,
            //     10.07,
            // ],
            // '6' => [
            //     'January 1, 2019 8am',
            //     NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
            //     false,
            //     2,
            //     1500,
            //     32.19,
            // ],
            // '7' => [
            //     'January 1, 2019 8am',
            //     NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
            //     false,
            //     0,
            //     300,
            //     4.5,
            // ],
            '8' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                false,
                0,
                600,
                10.72,
            ],
            '9' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                false,
                2,
                1500,
                43.96,
            ],
            '10' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                0,
                300,
                4.5,
            ],
            '11' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                0,
                600,
                11.58,
            ],
            '12' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                2,
                1500,
                48.19,
            ],
            '13' => [
                'January 1, 2019 8am',
                NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                false,
                0,
                300,
                4.5,
            ],
            '13' => [
                'January 1, 2019 8am',
                NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                false,
                0,
                600,
                10.08,
            ],
            '13' => [
                'January 1, 2019 8am',
                NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                false,
                12,
                1500,
                57.27,
            ],
        ];
    }
}
