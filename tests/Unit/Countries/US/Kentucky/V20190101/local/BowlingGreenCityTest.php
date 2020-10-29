<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101\local;

use Appleton\Taxes\Countries\US\Kentucky\BowlingGreenCity\BowlingGreenCity;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class BowlingGreenCityTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.bowling_green_city';
    private const TAX_CLASS = BowlingGreenCity::class;

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
                ->setExpectedAmountInCents(555)
                ->build()
        );
    }
}
