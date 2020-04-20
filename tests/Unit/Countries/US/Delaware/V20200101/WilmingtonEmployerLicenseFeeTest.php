<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Delaware\V20200101;

use Appleton\Taxes\Countries\US\Delaware\WilmingtonEmployerLicenseFee\WilmingtonEmployerLicenseFee;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class WilmingtonEmployerLicenseFeeTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const DELAWARE_LOCATION = 'us.delaware';
    private const WILMINGTON_LOCATION = 'us.delaware.wilmington';
    private const TAX_CLASS = WilmingtonEmployerLicenseFee::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
        $this->disableTestQueryRunner();
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideNoTaxTestData
     */
    public function testNoTax(TestParameters $parameters): void
    {
        $this->validateNoTax($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setHomeLocation(self::WILMINGTON_LOCATION)
                    ->setWorkLocation(self::WILMINGTON_LOCATION)
                    ->setWagesInCents(80000)
                    ->setMtdWagesInCents(null)
                    ->setMtdLiabilitiesInCents(null)
                    ->setExpectedAmountInCents(1500)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::WILMINGTON_LOCATION)
                    ->setWorkLocation(self::WILMINGTON_LOCATION)
                    ->setWagesInCents(200000)
                    ->setMtdWagesInCents(10000)
                    ->setMtdLiabilitiesInCents(10000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ]
        ];
    }
    public function provideNoTaxTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setHomeLocation(self::WILMINGTON_LOCATION)
                    ->setWorkLocation(self::DELAWARE_LOCATION)
                    ->setWagesInCents(30000)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::DELAWARE_LOCATION)
                    ->setWorkLocation(self::DELAWARE_LOCATION)
                    ->setWagesInCents(55000)
                    ->build()
            ],
        ];
    }
}
