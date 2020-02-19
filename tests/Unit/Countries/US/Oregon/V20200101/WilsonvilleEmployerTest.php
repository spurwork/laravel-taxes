<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Oregon\V20200101;

use Appleton\Taxes\Countries\US\Oregon\WilsonvilleEmployer\WilsonvilleEmployer;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class WilsonvilleEmployerTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const OREGON_LOCATION = 'us.oregon';
    private const WILSONVILLE_LOCATION = 'us.oregon.wilsonville';
    private const TAX_CLASS = WilsonvilleEmployer::class;

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
                    ->setHomeLocation(self::WILSONVILLE_LOCATION)
                    ->setWorkLocation(self::WILSONVILLE_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(150)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::WILSONVILLE_LOCATION)
                    ->setWorkLocation(self::WILSONVILLE_LOCATION)
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(500)
                    ->build()
            ],
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
                    ->setHomeLocation(self::WILSONVILLE_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(30000)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(55000)
                    ->build()
            ],
        ];
    }
}
