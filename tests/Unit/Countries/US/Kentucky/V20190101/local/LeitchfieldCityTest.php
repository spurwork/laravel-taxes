<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\LeitchfieldCity\LeitchfieldCity;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class LeitchfieldCityTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.leitchfield_city';
    private const TAX_CLASS = LeitchfieldCity::class;

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
                ->setExpectedAmountInCents(360)
                ->build()
        );
    }
}
