<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NorthDakota\V20190101;

use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaIncome\NorthDakotaIncome;
use Appleton\Taxes\Models\Countries\US\NorthDakota\NorthDakotaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NorthDakotaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.north_dakota';
    private const TAX_CLASS = NorthDakotaIncome::class;
    private const TAX_INFO_CLASS = NorthDakotaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NorthDakotaIncomeTaxInformation::createForUser([
            'filing_status' => NorthDakotaIncome::FILING_SINGLE,
            'exemptions' => 0,
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
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(200)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(800)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(2900)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NorthDakotaIncome::FILING_MARRIED,
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(700)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => NorthDakotaIncome::FILING_MARRIED])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(2500)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => NorthDakotaIncome::FILING_MARRIED,
                        'exemptions' => 2,
                    ])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(2200)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(5000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
