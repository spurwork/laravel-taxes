<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NorthDakota\V20200101;

use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaIncome\NorthDakotaIncome;
use Appleton\Taxes\Models\Countries\US\NorthDakota\NorthDakotaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class NorthDakotaIncomeTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = NorthDakotaIncome::class;
    private const TAX_INFO_CLASS = NorthDakotaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NorthDakotaIncomeTaxInformation::createForUser([
            'filing_status' => NorthDakotaIncome::FILING_SINGLE,
            'exempt' => false,
            'other_income' => 0,
            'deductions' => 0,
            'dependents_deduction_amount' => 0,
            'extra_withholding' => 0,
            'step_2_checked' => false,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideUseDefaultTestData
     */
    public function testTax_use_default(TestParameters $parameters): void
    {
        NorthDakotaIncomeTaxInformation::forUser($this->user)->delete();

        $this->validate($parameters);
    }

    public static function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            'A' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_SINGLE,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 0,
                        'extra_withholding' => 0,
                        'step_2_checked' => false,
                        'other_income' => 0,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(650)
                    ->build()
            ],
            'B' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_SINGLE,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 0,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 0,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(2009)
                    ->build()
            ],
            'C' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_SINGLE,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => false,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(55394)
                    ->build()
            ],
            'D' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_SINGLE,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(77377)
                    ->build()
            ],
            'E' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_SINGLE,
                        'dependents_deduction_amount' => 1000,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(75454)
                    ->build()
            ],
            'F' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_SINGLE,
                        'dependents_deduction_amount' => 1000,
                        'deductions' => 500,
                        'extra_withholding' => 10,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(76454)
                    ->build()
            ],
            'A2' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_JOINTLY,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 0,
                        'extra_withholding' => 0,
                        'step_2_checked' => false,
                        'other_income' => 0,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'B2' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_JOINTLY,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 0,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 0,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(650)
                    ->build()
            ],
            'C2' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_JOINTLY,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => false,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(39957)
                    ->build()
            ],
            'D2' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_JOINTLY,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(55394)
                    ->build()
            ],
            'E2' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_JOINTLY,
                        'dependents_deduction_amount' => 1000,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(53471)
                    ->build()
            ],
            'F2' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_JOINTLY,
                        'dependents_deduction_amount' => 1000,
                        'deductions' => 500,
                        'extra_withholding' => 10,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(54471)
                    ->build()
            ],
            'A3' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 0,
                        'extra_withholding' => 0,
                        'step_2_checked' => false,
                        'other_income' => 0,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'B3' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 0,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 0,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1240)
                    ->build()
            ],
            'C3' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => false,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(49850)
                    ->build()
            ],
            'D3' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'dependents_deduction_amount' => 0,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(73939)
                    ->build()
            ],
            'E3' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'dependents_deduction_amount' => 1000,
                        'deductions' => 500,
                        'extra_withholding' => 0,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(72016)
                    ->build()
            ],
            'F3' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => false,
                        'filing_status' => NorthDakotaIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'dependents_deduction_amount' => 1000,
                        'deductions' => 500,
                        'extra_withholding' => 10,
                        'step_2_checked' => true,
                        'other_income' => 1000,
                    ])
                    ->setWagesInCents(300000)
                    ->setExpectedAmountInCents(73016)
                    ->build()
            ],
        ];
    }

    public static function provideUseDefaultTestData(): array
    {
        return [
            '01' => [
                (new TestParametersBuilder())
                    ->setDate(self::DATE)
                    ->setHomeLocation(self::LOCATION)
                    ->setTaxClass(self::TAX_CLASS)
                    ->setTaxInfoClass(self::TAX_INFO_CLASS)
                    ->setWagesInCents(80000)
                    ->setPayPeriods(52)
                    ->setExpectedAmountInCents(6408)
                    ->build()
            ],
        ];
    }
}
