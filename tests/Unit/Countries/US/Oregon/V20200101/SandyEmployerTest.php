<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Oregon\V20200101;

use Appleton\Taxes\Countries\US\Oregon\SandyEmployer\SandyEmployer;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class SandyEmployerTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const OREGON_LOCATION = 'us.oregon';
    private const SANDY_LOCATION = 'us.oregon.sandy';
    private const TAX_CLASS = SandyEmployer::class;

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
                    ->setHomeLocation(self::SANDY_LOCATION)
                    ->setWorkLocation(self::SANDY_LOCATION)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(180)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::SANDY_LOCATION)
                    ->setWorkLocation(self::SANDY_LOCATION)
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(600)
                    ->build()
            ],
            '01=2' => [
                $builder
                    ->setHomeLocation(self::SANDY_LOCATION)
                    ->setWorkLocation(self::SANDY_LOCATION)
                    ->setWagesInCents(123400)
                    ->setExpectedAmountInCents(740)
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
                    ->setHomeLocation(self::SANDY_LOCATION)
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
