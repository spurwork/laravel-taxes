<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\SouthCarolina\V20190101;

use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\SouthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\SouthCarolina\SouthCarolinaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class SouthCarolinaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.south_carolina';
    private const TAX_CLASS = SouthCarolinaIncome::class;
    private const TAX_INFO_CLASS = SouthCarolinaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        SouthCarolinaIncomeTaxInformation::createForUser([
            'exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
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
                    ->setExpectedAmountInCents(1283)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['additional_withholding' => 20])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(3283)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 1])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(757)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 3])
                    ->setWagesInCents(55000)
                    ->setExpectedAmountInCents(1602)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(15384)
                    ->setExpectedAmountInCents(406)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(67307)
                    ->setExpectedAmountInCents(2726)
                    ->build()
            ],
            '07' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 4])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4275)
                    ->build()
            ],

        ];
    }
}
