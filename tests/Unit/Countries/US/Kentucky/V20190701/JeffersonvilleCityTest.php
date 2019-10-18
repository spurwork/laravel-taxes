<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190701;

use Appleton\Taxes\Countries\US\Kentucky\JeffersonvilleCity\JeffersonvilleCity;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class JeffersonvilleCityTest extends TaxTestCase
{
    private const DATE = '2019-07-01';
    private const LOCATION = 'us.kentucky.jeffersonville_city';
    private const TAX_CLASS = JeffersonvilleCity::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    public function testTax(): void
    {
        $this->validate(
            (new IncomeParametersBuilder())->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(600)
                ->build()
        );
    }
}
