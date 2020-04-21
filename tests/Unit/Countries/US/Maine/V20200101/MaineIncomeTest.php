<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Maine\V20200101;

use Appleton\Taxes\Countries\US\Maine\MaineIncome\MaineIncome;
use Appleton\Taxes\Models\Countries\US\Maine\MaineIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MaineIncomeTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.maine';
    private const TAX_CLASS = MaineIncome::class;
    private const TAX_INFO_CLASS = MaineIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        MaineIncomeTaxInformation::createForUser([
            'filing_status' => MaineIncome::FILING_SINGLE,
            'additional_withholding' => 0,
            'allowances' => 0,
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
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(700)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4000)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(11400)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(2400)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(9800)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(8700)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(80000)
                    ->setExpectedAmountInCents(2600)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(450000)
                    ->setExpectedAmountInCents(27700)
                    ->build()
            ],
             '10' => [
                $builder
                    ->setTaxInfoOptions([
                        'exempt' => true,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '11' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowances' => 2,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '12' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 20])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(2700)
                    ->build()
            ],
            '13' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowances' => 2,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(6000)
                    ->build()
            ],
            '14' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowances' => 2,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(13400)
                    ->build()
            ],
            '15' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4400)
                    ->build()
            ],
            '16' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(11800)
                    ->build()
            ],
            '17' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(10700)
                    ->build()
            ],
            '18' => [
                $builder
                    ->setTaxInfoOptions([
                        'allowances' => 2,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(80000)
                    ->setExpectedAmountInCents(4600)
                    ->build()
            ],
            '19' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MaineIncome::FILING_MARRIED,
                        'allowances' => 2,
                        'additional_withholding' => 20,
                    ])
                    ->setWagesInCents(450000)
                    ->setExpectedAmountInCents(29700)
                    ->build()
            ],
        ];
    }
}
