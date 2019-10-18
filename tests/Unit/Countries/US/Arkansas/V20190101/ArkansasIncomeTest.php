<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Arkansas\V20190101;

use Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\ArkansasIncome;
use Appleton\Taxes\Models\Countries\US\Arkansas\ArkansasIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ArkansasIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.arkansas';
    private const TAX_CLASS = ArkansasIncome::class;
    private const TAX_INFO_CLASS = ArkansasIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        ArkansasIncomeTaxInformation::createForUser([
            'exemptions' => 0,
            'additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(IncomeParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new IncomeParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            'test case 1' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(4540)
                    ->build()
            ],
            'test case 2' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 3,
                    ])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(4390)
                    ->build()
            ],
            'bracket 1' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(7500)
                    ->setExpectedAmountInCents(30)
                    ->build()
            ],
            'bracket 2' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(17500)
                    ->setExpectedAmountInCents(196)
                    ->build()
            ],
            'bracket 3' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(27500)
                    ->setExpectedAmountInCents(508)
                    ->build()
            ],
            'bracket 4' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(1050)
                    ->build()
            ],
            'bracket 5' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2752)
                    ->build()
            ],
            'bracket 6' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4806)
                    ->build()
            ],
            'additional withholding' => [
                $builder
                    ->setTaxInfoOptions([
                        'additional_withholding' => 10,
                    ])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(5540)
                    ->build()
            ],
            'exempt' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => true,
                    ])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
        ];
    }
}
