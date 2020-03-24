<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Missouri\V20200101;

use Appleton\Taxes\Countries\US\Missouri\StLouisEmployer\StLouisEmployer;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class StLouisEmployerTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.missouri.st_louis';
    private const TAX_CLASS = StLouisEmployer::class;

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
                ->setExpectedAmountInCents(150)
                ->build()
        );
    }
}
