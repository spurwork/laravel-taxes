<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Minnesota\V20190101;

use Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome\MinnesotaIncome;
use Appleton\Taxes\Models\Countries\US\Minnesota\MinnesotaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MinnesotaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
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
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1358)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4705)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(11847)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions([
                        'filing_status' => MinnesotaIncome::FILING_MARRIED,
                        'allowances' => 2,
                    ])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(3544)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['filing_status' => MinnesotaIncome::FILING_MARRIED])
                    ->setWagesInCents(200000)
                    ->setExpectedAmountInCents(11606)
                    ->build()
            ],
        ];
    }
}
