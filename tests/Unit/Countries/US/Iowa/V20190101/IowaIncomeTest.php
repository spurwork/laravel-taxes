<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Iowa\V20190101;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\Iowa\IowaIncome\IowaIncome;
use Appleton\Taxes\Models\Countries\US\Iowa\IowaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class IowaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.iowa';
    private const TAX_CLASS = IowaIncome::class;
    private const TAX_INFO_CLASS = IowaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(FederalIncome::class);
        $this->query_runner->addTax(self::TAX_CLASS);

        IowaIncomeTaxInformation::createForUser([
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
                    ->setExpectedAmountInCents(747)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['allowances' => 2])
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2372)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(70000)
                    ->setExpectedAmountInCents(2822)
                    ->build()
            ],
        ];
    }
}
