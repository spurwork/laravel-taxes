<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewYork\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Countries\US\NewYork\Yonkers\Yonkers;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class YonkersTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const YONKERS_LOCATION = 'us.new_york.yonkers';
    private const ALABAMA_LOCATION = 'us.alabama';
    private const TAX_CLASS = Yonkers::class;
    private const TAX_INFO_CLASS = NewYorkIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(NewYorkIncome::class);
        $this->query_runner->addTax(self::TAX_CLASS);

        NewYorkIncomeTaxInformation::createForUser([
            'filing_status' => NewYorkIncome::FILING_SINGLE,
            'ny_allowances' => 0,
            'nyc_allowances' => 10, // should not be used
            'ny_additional_withholding' => 10, // should not be used
            'nyc_additional_withholding' => 10, // should not be used
            'yonkers_additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);
    }

    /**
     * @dataProvider provideWorkInYonkersTestData
     */
    public function testTax_work_in_yonkers(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideWorkInDifferentStateTestData
     */
    public function testTax_work_in_different_state(TestParameters $parameters): void
    {
        $this->disableTestQueryRunner();
        $this->validate($parameters);
    }

    public function provideWorkInYonkersTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setHomeLocation(self::YONKERS_LOCATION)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setTaxInfoOptions(['ny_allowances' => 4])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(720)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['ny_allowances' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(245)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['ny_allowances' => 12])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(85)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 3,
                    ])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(417)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 5,
                    ])
                    ->setWagesInCents(90000)
                    ->setExpectedAmountInCents(585)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 2,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(1801)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 11,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(569)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(5000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '08' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NewYorkIncome::FILING_MARRIED,
                        'ny_allowances' => 2,
                        'yonkers_additional_withholding' => 5,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(2301)
                    ->build()
            ],
        ];
    }

    public function provideWorkInDifferentStateTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setHomeLocation(self::ALABAMA_LOCATION)
            ->setWorkLocation(self::YONKERS_LOCATION)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(25000)
                    ->setExpectedAmountInCents(106)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(240)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(350)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(90000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
        ];
    }
}
