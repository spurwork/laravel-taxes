<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20230101;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class AlabamaIncomeTest extends TaxTestCase
{
    private const DATE = '2023-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = AlabamaIncome::class;
    private const TAX_INFO_CLASS = AlabamaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(FederalIncome::class);
        $this->query_runner->addTax(AlabamaIncome::class);

        FederalIncomeTaxInformation::createForUser([
            'filing_status' => FederalIncome::FILING_SINGLE,
            'exemptions' => 0,
            'additional_withholding' => 0,
            'non_resident_alien' => false,
        ], $this->user);

        AlabamaIncomeTaxInformation::createForUser([
            'filing_status' => AlabamaIncome::FILING_SINGLE,
            'dependents' => 0,
            'additional_withholding' => 0,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = (new TestParametersBuilder())
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            'single_under_25999' => [
                $builder
                    ->setWagesInCents(47500)
                    ->setExpectedAmountInCents(1761)
                    ->build()
            ],
            'single_between_25999_and_35500' => [
                $builder
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(3019)
                    ->build()
            ],
            'single_over_35500' => [
                $builder
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4119)
                    ->build()
            ],
            'married_under_25999' => [
                $builder
                    ->setWagesInCents(47500)
                    ->setExpectedAmountInCents(1011)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_MARRIED,
                    ])
                    ->build()
            ],
            'married_between_25999_and_35500' => [
                $builder
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2557)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_MARRIED,
                    ])
                    ->build()
            ],
            'married_over_35500' => [
                $builder
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3657)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_MARRIED,
                    ])
                    ->build()
            ],
            'separate_under_12999' => [
                $builder
                    ->setWagesInCents(20000)
                    ->setExpectedAmountInCents(370)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_SEPERATE,
                    ])
                    ->build()
            ],
            'separate_between_12999_and_17750' => [
                $builder
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(946)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_SEPERATE,
                    ])
                    ->build()
            ],
            'separate_over_17750' => [
                $builder
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(1471)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_SEPERATE,
                    ])
                    ->build()
            ],
            'head_of_household_under_25999' => [
                $builder
                    ->setWagesInCents(47500)
                    ->setExpectedAmountInCents(1405)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_HEAD_OF_HOUSEHOLD,
                    ])
                    ->build()
            ],
            'head_of_household_between_25999_and_35500' => [
                $builder
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2875)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_HEAD_OF_HOUSEHOLD,
                    ])
                    ->build()
            ],
            'head_of_household_over_35500' => [
                $builder
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3975)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_HEAD_OF_HOUSEHOLD,
                    ])
                    ->build()
            ],
            'zero' => [
                $builder
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4263)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_ZERO,
                    ])
                    ->build()
            ],
            'dependents_less_than_50000' => [
                $builder
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(1231)
                    ->setTaxInfoOptions([
                        'dependents' => 2,
                    ])
                    ->build()
            ],
            'dependents_between_50000_and_100000' => [
                $builder
                    ->setWagesInCents(125000)
                    ->setExpectedAmountInCents(5061)
                    ->setTaxInfoOptions([
                        'dependents' => 2,
                    ])
                    ->build()
            ],
            'dependents_over_100000' => [
                $builder
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(8024)
                    ->setTaxInfoOptions([
                        'dependents' => 2,
                    ])
                    ->build()
            ],
            'additional_withholding' => [
                $builder
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(6619)
                    ->setTaxInfoOptions([
                        'additional_withholding' => 25,
                    ])
                    ->build()
            ],
        ];
    }
}
