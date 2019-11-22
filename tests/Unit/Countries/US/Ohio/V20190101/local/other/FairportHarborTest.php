<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FairportHarbor\FairportHarbor;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class FairportHarborTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.ohio.fairport_harbor';
    private const TAX_CLASS = FairportHarbor::class;

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
                ->setExpectedAmountInCents(600)
                ->build()
        );
    }
}
