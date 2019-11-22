<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\WestVirginia\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\CharlestonCityServiceFee\CharlestonCityServiceFee;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class CharlestonCityServiceFeeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.west_virginia.charleston';
    private const TAX_CLASS = CharlestonCityServiceFee::class;

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
                ->setWagesInCents(1)
                ->setExpectedAmountInCents(300)
                ->build()
        );
    }

    public function testTax_no_wages(): void
    {
        $this->validateNoTax(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(0)
                ->build()
        );
    }
}
