<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewYork\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkMetropolitanCommuterTransportationMobility\NewYorkMetropolitanCommuterTransportationMobility;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewYorkMetropolitanCommuterTransportationMobilityTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_york';
    private const TAX_CLASS = NewYorkMetropolitanCommuterTransportationMobility::class;

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
                ->setWagesInCents(100000)
                ->setExpectedAmountInCents(340)
                ->build()
        );
    }
}
