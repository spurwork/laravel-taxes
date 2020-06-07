<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Pennsylvania\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\PennsylvaniaLSTTaxEmployer;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class PennsylvaniaLSTTaxEmployerTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.pennsylvania';
    private const TAX_CLASS = PennsylvaniaLSTTaxEmployer::class;
    private const TAX_INFO_CLASS = PennsylvaniaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        PennsylvaniaIncomeTaxInformation::createForUser([
            'exempt' => false,
            'exempt_from_municipal_lst' => false,
            'exempt_from_school_district_lst' => false,
            'municipal_lst_total' => 0,
            'school_district_lst_total' => 0,
            'lst_paid_to_previous_employers' => 0,
            'wages_from_previous_employers' => 0,
            'municipal_lst_lie_total' => 0,
            'school_district_lst_lie_total' => 0,
            'exempt_for_low_income' => false,
        ], $this->user);
    }

    /** @dataProvider dataProvider */
    public function testLiability(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function dataProvider(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setWorkLocation(self::LOCATION)
            ->setPayPeriods(52)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS);

        return [
            'no LST no tax' => [
                $builder
                        ->setTaxInfoOptions([
                        'municipal_lst_total' => 0,
                        'school_district_lst_total' => 0,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build(),
            ],
            'exempt from muni no LIE, no previous wages, no liability' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(400) // full $4 becuase total LST is less than 10
                    ->build(),
            ],
            'exempt from muni no LIE, no previous wages, partial liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(400)
                    ->setExpectedAmountInCents(0) // $0 because $4 in liabilities has been paid
                    ->build(),
            ],
            'exempt from muni no LIE, no previous wages, over liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(1000)
                    ->setExpectedAmountInCents(0) // $0 because over $9 in the liability has been paid
                    ->build(),
            ],
            'exempt from muni LIE, previous wages + previous employer wages over LIE catch up needed, no liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 8001,
                        'municipal_lst_lie_total' => 16000,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(800100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(900) // school district + municipal catch up
                    ->build(),
            ],
            'exempt from muni LIE, previous wages over LIE catch up needed, no liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 16000,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(900) // school district + municipal catch up
                    ->build(),
            ],
            'exempt from muni LIE, previous wages over LIE catch up needed, previous LST paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 52,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 16000,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0) // $52 in previously paid
                    ->build(),
            ],
            'exempt from muni LIE, previous wages over LIE catch up needed, all LST paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 5,
                        'school_district_lst_total' => 4,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 16000,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(900)
                    ->setExpectedAmountInCents(0) // $9 is max, $9 has been previously paid
                    ->build(),
            ],
            'exempt from muni LIE, previous wages over LIE catch up needed, previous LST paid, pay periods exempt' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 40,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 16000,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(200)
                    ->setPayPeriodsExempt(6)
                    ->setExpectedAmountInCents(481) // $52 is max, $40 has been previously paid, $12 left / pay periods + muni catch up
                    ->build(),
            ],
            'exempt from muni LIE, previous wages over LIE catch up needed, previous LST paid, pay periods exempt' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 16000,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setPayPeriodsExempt(48)
                    ->setExpectedAmountInCents(3715) // $52 is max, $40 has been previously paid, $12 left / pay periods + muni catch up
                    ->build(),
            ],
            'not exempt from school district no LIE, no previous wages, no liability' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => false,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(100) // 1 because total LST is greater than 10 so it's total lst amount / pay periods
                    ->build(),
            ],
            'exempt from school district no LIE, no previous wages, partial liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(400)
                    ->setExpectedAmountInCents(69) // .69 because total LST is greater than 10 so it's total lst amount - previous paid lst / pay periods

                    ->build(),
            ],
            'exempt from school district no LIE, no previous wages, all liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(5200)
                    ->setExpectedAmountInCents(0) // $0 because $52 in the liability has been paid
                    ->build(),
            ],
            'exempt from school district no LIE, no previous wages, over liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 0,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(5300)
                    ->setExpectedAmountInCents(0) // $0 because over $52 in the liability has been paid
                    ->build(),
            ],
            'exempt from school district LIE, no previous wages, no liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 16000,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(77) // .77 because LIE limit hasn't been hit
                    ->build(),
            ],
            'exempt from school district LIE, previous wages, no liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 16000,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(800000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(77) // .77 because LIE limit hasn't been hit
                    ->build(),
            ],
            'exempt from school district LIE, previous wages + previous employer wages over LIE catch up needed, no liabilities paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 8001,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 16000,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(800100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setPayPeriodsExempt(6)
                    ->setExpectedAmountInCents(215) // municipal lst amount a year / pay periods + catch up
                    ->build(),
            ],
            'exempt from school district LIE, previous wages over LIE catch up needed, part of previous LST paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 40,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 16000,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setPayPeriodsExempt(6)
                    ->setExpectedAmountInCents(215) // $52 is max, $40 has been previously paid, $12 left / pay periods + catch up amount
                    ->build(),
            ],
            'exempt from school district LIE, previous wages over LIE catch up needed, previous LST paid, pay periods exempt' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 40,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 16000,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setPayPeriodsExempt(6)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(900)
                    ->setExpectedAmountInCents(198) // $40 is max, $9 has been previously paid, $31 left pay periods + catch up
                    ->build(),
            ],
            'exempt from municipal and school district LIE, previous wages over LIE catch up needed, previous LST paid, pay periods exempt' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => true,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 0,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 16000,
                        'school_district_lst_lie_total' => 16000,
                        'exempt_for_low_income' => true,
                    ])
                    ->setWagesInCents(0)
                    ->setPayPeriodsExempt(6)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(600) // muni catch up + school catch up
                    ->build(),
            ],
            'exempt from school district LIE, previous wages over LIE catch up needed, previous LST paid' => [
                $builder
                    ->setTaxInfoOptions([
                        'municipal_lst_total' => 40,
                        'school_district_lst_total' => 12,
                        'exempt_from_municipal_lst' => false,
                        'exempt_from_school_district_lst' => true,
                        'lst_paid_to_previous_employers' => 52,
                        'wages_from_previous_employers' => 0,
                        'municipal_lst_lie_total' => 0,
                        'school_district_lst_lie_total' => 16000,
                        'exempt_for_low_income' => false,
                    ])
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(1600100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0) // $52 is max, $52 has been previously paid
                    ->build(),
            ],
        ];
    }
}
