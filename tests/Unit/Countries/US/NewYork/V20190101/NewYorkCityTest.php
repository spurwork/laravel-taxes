<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewYork\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkCity\NewYorkCity;
use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewYorkCityTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_york';
    private const TAX_CLASS = NewYorkCity::class;
    private const TAX_INFO_CLASS = NewYorkIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NewYorkIncomeTaxInformation::createForUser([
            'filing_status' => NewYorkIncome::FILING_SINGLE,
            'ny_allowances' => 10, // should not be used
            'nyc_allowances' => 0,
            'ny_additional_withholding' => 10, // should not be used
            'nyc_additional_withholding' => 0,
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
                    ->setTaxInfoOptions(['nyc_allowances' => 4])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(2942)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(['nyc_allowances' => 2])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(1050)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['nyc_allowances' => 12])
                    ->setWagesInCents(50000)
                    ->setExpectedAmountInCents(372)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['nyc_allowances' => 3])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(1777)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['nyc_allowances' => 5])
                    ->setWagesInCents(90000)
                    ->setExpectedAmountInCents(2447)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['nyc_allowances' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(7324)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions(['nyc_allowances' => 11])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(2383)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions([
                        'nyc_allowances' => 11,
                        'nyc_additional_withholding' => 10,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3383)
                    ->build()
            ],
        ];
    }
}
