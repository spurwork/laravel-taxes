<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\FederalIncome\V20200101;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class FederalIncomeTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = FederalIncome::class;
    private const TAX_INFO_CLASS = FederalIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        FederalIncomeTaxInformation::createForUser([
            'non_resident_alien' => false, // not needed anymore
            'exempt' => false, // either
            'filing_status' => FederalIncome::FILING_SINGLE, // either
            'form_version' => '2019', // either
            'dependents' => 0, // new
            'deductions' => 0, // new
            'extra_withholding' => 0, // new
            'step_2_checked' => false, // new
            'other_income' => 0, // new
            'additional_withholding' => 0, // old
            'exemptions' => 0, // old
        ], $this->user);
    }

    /**
     * @dataProvider provideTestDataNewForm
     */
    public function testTaxNewForm(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideTestDataOldForm
     */
    public function testTaxOldForm(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideUseDefaultTestData
     */
    public function testTax_use_default(TestParameters $parameters): void
    {
        FederalIncomeTaxInformation::forUser($this->user)->delete();

        $this->validate($parameters);
    }

    public function provideTestDataOldForm(): array
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
                        'filing_status' => FederalIncome::FILING_SINGLE,
                        'form_version' => '2019',
                        'additional_withholding' => 0,
                        'exemptions' => 0,
                    ])
                    ->setWagesInCents(26000)
                    ->setExpectedAmountInCents(1870)
                    ->build()
            ],
            // 'B' => [
            //     $builder
            //         ->setTaxInfoOptions([
            //             'exemptions' => 4,
            //             'filing_status' => FederalIncome::FILING_MARRIED,
            //         ])
            //         ->setWagesInCents(47525)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'C' => [
            //     $builder
            //         ->setTaxInfoOptions([
            //             'exemptions' => 2,
            //         ])
            //         ->setWagesInCents(11233)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'D' => [
            //     $builder
            //         ->setTaxInfoOptions(null)
            //         ->setWagesInCents(86514)
            //         ->setExpectedAmountInCents(9460)
            //         ->build()
            // ],
            // 'E' => [
            //     $builder
            //         ->setTaxInfoOptions([
            //             'exemptions' => 3,
            //             'filing_status' => FederalIncome::FILING_MARRIED,
            //         ])
            //         ->setWagesInCents(36757)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'H' => [
            //     $builder
            //         ->setTaxInfoOptions([
            //             'exemptions' => 2,
            //         ])
            //         ->setWagesInCents(80000)
            //         ->setExpectedAmountInCents(6411)
            //         ->build()
            // ],
        ];
    }

    public function provideTestDataNewForm(): array
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
                        'filing_status' => FederalIncome::FILING_SINGLE,
                        'form_version' => '2020',
                        'dependents' => 000,
                        'deductions' => 000,
                        'extra_withholding' => 000,
                        'step_2_checked' => false,
                        'other_income' => 000,
                    ])
                    ->setWagesInCents(26000)
                    ->setExpectedAmountInCents(1870)
                    ->build()
            ],
            // 'B' => [
            //     $builder
            //         ->setTaxInfoOptions([
            //             'exemptions' => 4,
            //             'filing_status' => FederalIncome::FILING_MARRIED,
            //         ])
            //         ->setWagesInCents(47525)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'C' => [
            //     $builder
            //         ->setTaxInfoOptions([
            //             'exemptions' => 2,
            //         ])
            //         ->setWagesInCents(11233)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'D' => [
            //     $builder
            //         ->setTaxInfoOptions(null)
            //         ->setWagesInCents(86514)
            //         ->setExpectedAmountInCents(9460)
            //         ->build()
            // ],
            // 'E' => [
            //     $builder
            //         ->setTaxInfoOptions([
            //             'exemptions' => 3,
            //             'filing_status' => FederalIncome::FILING_MARRIED,
            //         ])
            //         ->setWagesInCents(36757)
            //         ->setExpectedAmountInCents(0)
            //         ->build()
            // ],
            // 'H' => [
            //     $builder
            //         ->setTaxInfoOptions([
            //             'exemptions' => 2,
            //         ])
            //         ->setWagesInCents(80000)
            //         ->setExpectedAmountInCents(6411)
            //         ->build()
            // ],
        ];
    }

    public function provideUseDefaultTestData(): array
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
                    ->setExpectedAmountInCents(8350)
                    ->build()
            ],
        ];
    }
}
