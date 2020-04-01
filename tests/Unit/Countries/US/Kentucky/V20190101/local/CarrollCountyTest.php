<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CarrollCounty\CarrollCounty;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class CarrollCountyTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.carroll_county';
    private const TAX_CLASS = CarrollCounty::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
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
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setWagesInCents(30000)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setWagesInCents(250000)
                    ->setYtdWagesInCents(250000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setWagesInCents(250100)
                    ->setYtdWagesInCents(250000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(1)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setWagesInCents(250000)
                    ->setYtdWagesInCents(250100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(1)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdWagesInCents(500000)
                    ->setYtdLiabilitiesInCents(1000000)
                    ->setExpectedAmountInCents(100)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdWagesInCents(5000000)
                    ->setYtdLiabilitiesInCents(5000000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
