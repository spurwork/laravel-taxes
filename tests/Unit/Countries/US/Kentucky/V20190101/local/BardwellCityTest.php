<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\BardwellCity\BardwellCity;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class BardwellCityTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.bardwell_city';
    private const TAX_CLASS = BardwellCity::class;

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
                ->setExpectedAmountInCents(150)
                ->build()
        );
    }
}
