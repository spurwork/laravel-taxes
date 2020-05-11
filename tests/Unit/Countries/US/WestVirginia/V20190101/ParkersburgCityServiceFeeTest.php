<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\WestVirginia\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee\ParkersburgCityServiceFee;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class ParkersburgCityServiceFeeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.west_virginia.parkersburg';
    private const OTHER_LOCATION = 'us.west_virginia';
    private const TAX_CLASS = ParkersburgCityServiceFee::class;

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
                ->setWagesInCents(1000)
                ->setWtdLiabilitiesInCents(2000)
                ->setExpectedAmountInCents(0)
                ->build()
        );
    }

    public function testTax_no_wages(): void
    {
        $this->validateNoTax(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                // ->setWorkLocation(self::OTHER_LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(2000)
                ->setWtdLiabilitiesInCents(0)
                ->setExpectedAmountInCents(0)
                ->build()
        );
    }
}
