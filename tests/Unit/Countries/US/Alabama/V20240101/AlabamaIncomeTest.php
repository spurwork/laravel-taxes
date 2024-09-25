<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20240101;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Closure;
use ReflectionException;

class AlabamaIncomeTest extends TaxTestCase
{
    private const DATE = '2024-01-01';
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
     * @throws ReflectionException
     */
    public function testTax(Closure $parameters): void
    {
        $this->validate($parameters->bindTo($this)());
    }

    public static function provideTestData(): array
    {
        return [
            'single_under_25999' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(47500)
                    ->setExpectedAmountInCents(1768)
                    ->build()
            ],
            'single_between_25999_and_35500' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(3029)
                    ->build()
            ],
            'single_over_35500' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4129)
                    ->build()
            ],
            'married_under_25999' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(47500)
                    ->setExpectedAmountInCents(1018)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_MARRIED,
                    ])
                    ->build()
            ],
            'married_between_25999_and_35500' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2567)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_MARRIED,
                    ])
                    ->build()
            ],
            'married_over_35500' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3667)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_MARRIED,
                    ])
                    ->build()
            ],
            'separate_under_12999' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(20000)
                    ->setExpectedAmountInCents(370)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_SEPERATE,
                    ])
                    ->build()
            ],
            'separate_between_12999_and_17750' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(953)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_SEPERATE,
                    ])
                    ->build()
            ],
            'separate_over_17750' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(1478)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_SEPERATE,
                    ])
                    ->build()
            ],
            'head_of_household_under_25999' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(47500)
                    ->setExpectedAmountInCents(1412)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_HEAD_OF_HOUSEHOLD,
                    ])
                    ->build()
            ],
            'head_of_household_between_25999_and_35500' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(75000)
                    ->setExpectedAmountInCents(2884)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_HEAD_OF_HOUSEHOLD,
                    ])
                    ->build()
            ],
            'head_of_household_over_35500' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3984)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_HEAD_OF_HOUSEHOLD,
                    ])
                    ->build()
            ],
            'zero' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4273)
                    ->setTaxInfoOptions([
                        'filing_status' => AlabamaIncome::FILING_ZERO,
                    ])
                    ->build()
            ],
            'dependents_less_than_50000' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(1238)
                    ->setTaxInfoOptions([
                        'dependents' => 2,
                    ])
                    ->build()
            ],
            'dependents_between_50000_and_100000' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(125000)
                    ->setExpectedAmountInCents(5101)
                    ->setTaxInfoOptions([
                        'dependents' => 2,
                    ])
                    ->build()
            ],
            'dependents_over_100000' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(8065)
                    ->setTaxInfoOptions([
                        'dependents' => 2,
                    ])
                    ->build()
            ],
            'additional_withholding' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(6629)
                    ->setTaxInfoOptions([
                        'additional_withholding' => 25,
                    ])
                    ->build()
            ],
            'no_overtime' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(1430)
                    ->build()
            ],
            'overtime' => [
                fn() => $this->paramsBuilder()
                    ->setWagesInCents(40000)
                    ->setOvertimeWagesInCents(15000)
                    ->setExpectedAmountInCents(1351)
                    ->setExpectedEarningsInCents(55000)
                    ->build()
            ],
        ];
    }

    private function paramsBuilder() :TestParametersBuilder
    {
        return (new TestParametersBuilder())
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);
    }
}
