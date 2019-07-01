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
    public function testNewJerseyIncome($date, $filing_status, $exempt, $exemptions, $earnings, $tax_rate_table, $result)
    {
        NewJerseyIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'exempt' => $exempt,
            'exemptions' => $exemptions,
            'filing_status' => $filing_status,
            'tax_rate_table'=> $tax_rate_table,
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
        // date
        // filing status
        // exempt
        // exemptions
        // earnings
        // tax rate table
        // results
        return [
            // First set tax rate table is null so the value
            // is the filing status
            '0' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_SINGLE,
                false,
                0,
                300,
                null,
                4.5,
            ],
            // exempt, should be null
            '1' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_SINGLE,
                true,
                0,
                300,
                null,
                null,
            ],
            '2' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_SINGLE,
                false,
                2,
                1500,
                null,
                57.69,
            ],
            '3' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                false,
                0,
                300,
                null,
                4.5,
            ],
            '4' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                false,
                2,
                1500,
                null,
                32.19,
            ],
            '5' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                false,
                0,
                300,
                null,
                4.5,
            ],
            '6' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                false,
                2,
                1500,
                null,
                57.69,
            ],
            '7' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                0,
                300,
                null,
                4.5,
            ],
            '8' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                2,
                1500,
                null,
                32.19,
            ],
            '9' => [
                'January 1, 2019 8am',
                NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                false,
                0,
                300,
                null,
                4.5,
            ],
            '10' => [
                'January 1, 2019 8am',
                NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                false,
                12,
                1500,
                null,
                25.61,
            ],
            // This set is using the selected tax rate table
            // it overrides the filing status and uses the
            // table the worker selected on box 3
            '11' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_SINGLE,
                false,
                0,
                300,
                'A',
                4.5,
            ],
            '12' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_SINGLE,
                true,
                0,
                300,
                'A',
                null,
            ],
            '13' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_SINGLE,
                false,
                2,
                1500,
                'A',
                57.69,
            ],
            '14' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                false,
                0,
                300,
                'B',
                4.5,
            ],
            '15' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT,
                false,
                2,
                1500,
                'B',
                32.19,
            ],
            '16' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                false,
                0,
                300,
                'C',
                4.5,
            ],
            '17' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE,
                false,
                2,
                1500,
                'C',
                43.96,
            ],
            '18' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                0,
                300,
                'D',
                4.5,
            ],
            '19' => [
                'January 1, 2019 8am',
                NewJerseyIncome::FILING_HEAD_OF_HOUSEHOLD,
                false,
                2,
                1500,
                'D',
                48.19,
            ],
            '20' => [
                'January 1, 2019 8am',
                NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                false,
                0,
                300,
                'E',
                4.5,
            ],
            '21' => [
                'January 1, 2019 8am',
                NewJerseyIncome::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT,
                false,
                2,
                1500,
                'E',
                57.26,
            ],
        ];
    }
}
