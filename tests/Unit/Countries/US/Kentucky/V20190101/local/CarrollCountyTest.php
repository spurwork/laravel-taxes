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
            'earnings not enough' => [
                $builder
                    ->setWagesInCents(30000)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'earnings at start' => [
                $builder
                    ->setWagesInCents(500000)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'earnings over start' => [
                $builder
                    ->setWagesInCents(510000)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(100)
                    ->build()
            ],
            'total earnings not enough' => [
                $builder
                    ->setWagesInCents(200000)
                    ->setYtdWagesInCents(200000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'total earnings at start' => [
                $builder
                    ->setWagesInCents(250000)
                    ->setYtdWagesInCents(250000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            'total earnings over start - earnings' => [
                $builder
                    ->setWagesInCents(250100)
                    ->setYtdWagesInCents(250000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(1)
                    ->build()
            ],
            'total earnings over start - ytd earnings' => [
                $builder
                    ->setWagesInCents(250000)
                    ->setYtdWagesInCents(250100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(1)
                    ->build()
            ],
            'ytd earnings at start' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdWagesInCents(500000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(100)
                    ->build()
            ],
            'already started tax' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(100)
                    ->setExpectedAmountInCents(100)
                    ->build()
            ],
            'over max tax' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(5000000)
                    ->setExpectedAmountInCents(100)
                    ->build()
            ],
        ];
    }
}
