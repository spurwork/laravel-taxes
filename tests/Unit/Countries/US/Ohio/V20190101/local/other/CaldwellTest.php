<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Ohio\V20190101\local\other;

use Appleton\Taxes\Countries\US\Ohio\Caldwell\Caldwell;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class CaldwellTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.ohio.caldwell';
    private const TAX_CLASS = Caldwell::class;

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
                ->setExpectedAmountInCents(300)
                ->build()
        );
    }
}
