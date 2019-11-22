<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kansas\V20190101;

use Appleton\Taxes\Countries\US\Kansas\KansasIncome\KansasIncome;
use Appleton\Taxes\Models\Countries\US\Kansas\KansasIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class KansasIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kansas';
    private const TAX_CLASS = KansasIncome::class;
    private const TAX_INFO_CLASS = KansasIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        KansasIncomeTaxInformation::createForUser([
            'allowance_rate' => KansasIncome::ALLOWANCE_RATE_SINGLE,
            'total_allowances' => 0,
            'additional_withholding' => 0,
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
            'exempt' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'single bracket 01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(5000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'single bracket 02' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(751)
                    ->build()
            ],
            'single bracket 03' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1701)
                    ->build()
            ],
            'single bracket 04' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2781)
                    ->build()
            ],
            'married bracket 01' => [
                $builder
                    ->setTaxInfoOptions(['allowance_rate' => KansasIncome::ALLOWANCE_RATE_JOINT])
                    ->setWagesInCents(5000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'married bracket 02' => [
                $builder
                    ->setTaxInfoOptions(['allowance_rate' => KansasIncome::ALLOWANCE_RATE_JOINT])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(482)
                    ->build()
            ],
            'married bracket 03' => [
                $builder
                    ->setTaxInfoOptions(['allowance_rate' => KansasIncome::ALLOWANCE_RATE_JOINT])
                    ->setWagesInCents(80000)
                    ->setExpectedAmountInCents(2202)
                    ->build()
            ],
            'married bracket 04' => [
                $builder
                    ->setTaxInfoOptions(['allowance_rate' => KansasIncome::ALLOWANCE_RATE_JOINT])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(5968)
                    ->build()
            ],
            'exemptions' => [
                $builder
                    ->setTaxInfoOptions(['total_allowances' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1247)
                    ->build()
            ],
            'additional withholding' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 15])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(3201)
                    ->build()
            ],
            'pay periods' => [
                (new TestParametersBuilder())
                    ->setDate(self::DATE)
                    ->setHomeLocation(self::LOCATION)
                    ->setTaxClass(self::TAX_CLASS)
                    ->setTaxInfoClass(self::TAX_INFO_CLASS)
                    ->setPayPeriods(26)
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1192)
                    ->build()
            ],
            'test case 01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(751)
                    ->build()
            ],
            'test case 02' => [
                $builder
                    ->setTaxInfoOptions(['total_allowances' => 2])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(482)
                    ->build()
            ],
            'test case 03' => [
                $builder
                    ->setTaxInfoOptions(['total_allowances' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1247)
                    ->build()
            ],
            'test case 04' => [
                $builder
                    ->setTaxInfoOptions(['allowance_rate' => KansasIncome::ALLOWANCE_RATE_JOINT])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(482)
                    ->build()
            ],
            'test case 05' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowance_rate' => KansasIncome::ALLOWANCE_RATE_JOINT,
                        'total_allowances' => 2
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(214)
                    ->build()
            ],
            'test case 06' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowance_rate' => KansasIncome::ALLOWANCE_RATE_JOINT,
                        'total_allowances' => 2
                    ])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(834)
                    ->build()
            ],
            'test case 07' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowance_rate' => KansasIncome::ALLOWANCE_RATE_JOINT,
                        'total_allowances' => 2
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(2798)
                    ->build()
            ],
        ];
    }
}
