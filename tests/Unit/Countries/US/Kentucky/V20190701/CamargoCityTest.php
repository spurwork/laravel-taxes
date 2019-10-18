<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190701;

use Appleton\Taxes\Countries\US\Kentucky\CamargoCity\CamargoCity;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class CamargoCityTest extends TaxTestCase
{
    private const DATE = '2019-07-01';
    private const LOCATION = 'us.kentucky.camargo_city';
    private const TAX_CLASS = CamargoCity::class;

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
