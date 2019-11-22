<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Louisiana\V20190101;

use Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\LouisianaIncome;
use Appleton\Taxes\Models\Countries\US\Louisiana\LouisianaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class LouisianaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.louisiana';
    private const TAX_CLASS = LouisianaIncome::class;
    private const TAX_INFO_CLASS = LouisianaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        LouisianaIncomeTaxInformation::createForUser([
            'filing_status' => LouisianaIncome::FILING_SINGLE,
            'exemptions' => 0,
            'dependents' => 0,
            'exempt' => false,
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
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 1,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(1942)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => LouisianaIncome::FILING_MARRIED,
                        'exemptions' => 2,
                        'dependents' => 3,
                    ])
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(7855)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(230000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(725)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions([
                        'dependents' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(685)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 1,
                        'dependents' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(503)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(281)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(2923)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => LouisianaIncome::FILING_MARRIED,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(630)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => LouisianaIncome::FILING_MARRIED,
                        'exemptions' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(448)
                    ->build()
            ],
            '10' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => LouisianaIncome::FILING_MARRIED,
                        'exemptions' => 1,
                        'dependents' => 1,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(407)
                    ->build()
            ],
            '11' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => LouisianaIncome::FILING_MARRIED,
                        'exemptions' => 2,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(185)
                    ->build()
            ],
            '12' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => LouisianaIncome::FILING_MARRIED,
                        'exemptions' => 2,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(60000)
                    ->setExpectedAmountInCents(1012)
                    ->build()
            ],
            '13' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => LouisianaIncome::FILING_MARRIED,
                        'exemptions' => 2,
                        'dependents' => 2,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(6366)
                    ->build()
            ],
        ];
    }
}
