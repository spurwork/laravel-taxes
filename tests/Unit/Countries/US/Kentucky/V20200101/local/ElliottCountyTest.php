<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20200101;

use Appleton\Taxes\Countries\US\Kentucky\ElliottCounty\ElliottCounty;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ElliottCountyTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.kentucky.elliott_county';
    private const TAX_CLASS = ElliottCounty::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    public function testTax(): void
    {
        $this->validate(
            (new TestParametersBuilder())->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(300)
                ->build()
        );
    }
}
