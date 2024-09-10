<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Hawaii\V20190101;

use Appleton\Taxes\Countries\US\Hawaii\HawaiiIncome\HawaiiIncome;
use Appleton\Taxes\Models\Countries\US\Hawaii\HawaiiIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class HawaiiIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.hawaii';
    private const TAX_CLASS = HawaiiIncome::class;
    private const TAX_INFO_CLASS = HawaiiIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        HawaiiIncomeTaxInformation::createForUser([
            'filing_status' => HawaiiIncome::FILING_SINGLE,
            'exemptions' => 0,
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
            '00' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1468)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(2563)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 4])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(10047)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => HawaiiIncome::FILING_HEAD_OF_HOUSEHOLD])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1468)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => HawaiiIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'exemptions' => 2
                    ])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(2563)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => HawaiiIncome::FILING_HEAD_OF_HOUSEHOLD,
                        'exemptions' => 4
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(10047)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => HawaiiIncome::FILING_MARRIED])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1060)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => HawaiiIncome::FILING_MARRIED,
                        'exemptions' => 2
                    ])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1996)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => HawaiiIncome::FILING_MARRIED,
                        'exemptions' => 4
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(8930)
                    ->build()
            ],
            '10' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => HawaiiIncome::FILING_MARRIED,
                        'exemptions' => 4,
                        'additional_withholding' => 100,
                    ])
                    ->setWagesInCents(150000)
                    ->setExpectedAmountInCents(18930)
                    ->build()
            ],
        ];
    }
}
