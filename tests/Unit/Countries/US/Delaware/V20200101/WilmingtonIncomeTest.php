<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Delaware\V20200101;

use Appleton\Taxes\Countries\US\Delaware\Wilmington\WilmingtonIncome;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class WilmingtonIncomeTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.delaware.wilmington';
    private const TAX_CLASS = WilmingtonIncome::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    public function testTax(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(375)
                ->build()
        );
    }
}
