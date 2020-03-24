<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Minnesota\V20200101;

use Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome\MinnesotaIncome;
use Appleton\Taxes\Models\Countries\US\Minnesota\MinnesotaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MinnesotaIncomeTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.minnesota';
    private const TAX_CLASS = MinnesotaIncome::class;
    private const TAX_INFO_CLASS = MinnesotaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        MinnesotaIncomeTaxInformation::createForUser([
            'filing_status' => MinnesotaIncome::FILING_SINGLE,
            'allowances' => 0,
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
                    ->setExpectedAmountInCents(1224)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 20])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(3224)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4465)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(11360)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MinnesotaIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3277)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MinnesotaIncome::FILING_MARRIED])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(10995)
                    ->build()
            ],
        ];
    }
}
