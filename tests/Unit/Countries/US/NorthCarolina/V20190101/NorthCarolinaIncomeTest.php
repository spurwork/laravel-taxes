<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NorthCarolina\V20190101;

use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NorthCarolinaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.north_carolina';
    private const TAX_CLASS = NorthCarolinaIncome::class;
    private const TAX_INFO_CLASS = NorthCarolinaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NorthCarolinaIncomeTaxInformation::createForUser([
             'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
             'dependents' => 0,
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
            'case study A' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(27000)
                    ->setExpectedAmountInCents(400)
                    ->build()
            ],
            'case study B' => [
                $builder
                    ->setTaxInfoOptions(['dependents' => 3])
                    ->setWagesInCents(78500)
                    ->setExpectedAmountInCents(2900)
                    ->build()
            ],
            'case study C' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NorthCarolinaIncome::FILING_MARRIED])
                    ->setWagesInCents(16080)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'case study D' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NorthCarolinaIncome::FILING_MARRIED,
                        'dependents' => 5,
                        'additional_withholding' => 15.00,
                    ])
                    ->setWagesInCents(28000)
                    ->setExpectedAmountInCents(1500)
                    ->build()
            ],
            'case study E' => [
                $builder
                    ->setTaxInfoOptions([
                        'dependents' => 1,
                        'additional_withholding' => 25.00,
                    ])
                    ->setWagesInCents(45500)
                    ->setExpectedAmountInCents(3700)
                    ->build()
            ],
            'case study F' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NorthCarolinaIncome::FILING_MARRIED])
                    ->setWagesInCents(36500)
                    ->setExpectedAmountInCents(900)
                    ->build()
            ],
            'case study G' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
                        'dependents' => 8,
                    ])
                    ->setWagesInCents(62500)
                    ->setExpectedAmountInCents(1100)
                    ->build()
            ],
        ];
    }
}
