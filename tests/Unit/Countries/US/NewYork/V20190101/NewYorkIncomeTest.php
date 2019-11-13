<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewYork\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewYorkIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_york';
    private const TAX_CLASS = NewYorkIncome::class;
    private const TAX_INFO_CLASS = NewYorkIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NewYorkIncomeTaxInformation::createForUser([
            'filing_status' => NewYorkIncome::FILING_SINGLE,
            'ny_allowances' => 0,
            'nyc_allowances' => 10, // should not be used
            'ny_additional_withholding' => 0,
            'nyc_additional_withholding' => 10, // should not be used
            'yonkers_additional_withholding' => 10, // should not be used
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
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(14500)
                    ->setExpectedAmountInCents(10)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(630)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['ny_allowances' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1460)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['ny_allowances' => 3])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2553)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['ny_allowances' => 3])
                    ->setWagesInCents(90000)
                    ->setExpectedAmountInCents(3795)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['ny_allowances' => 2])
                    ->setWagesInCents(130000)
                    ->setExpectedAmountInCents(6398)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions(['ny_allowances' => 11])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3460)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NewYorkIncome::FILING_MARRIED])
                    ->setWagesInCents(14500)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NewYorkIncome::FILING_MARRIED])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(588)
                    ->build()
            ],
            '09' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 2,
                    ])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1397)
                    ->build()
            ],
            '10' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 3,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2487)
                    ->build()
            ],
            '11' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 3,
                    ])
                    ->setWagesInCents(90000)
                    ->setExpectedAmountInCents(3729)
                    ->build()
            ],
            '12' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 2,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(10751)
                    ->build()
            ],
            '13' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 11,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3395)
                    ->build()
            ],
            '14' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 11,
                        'ny_additional_withholding' => 10
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4395)
                    ->build()
            ],
        ];
    }
}
