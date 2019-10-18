<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Oregon\V20190101;

use Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\EugeneEmployer;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class EugeneEmployerTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.oregon';
    private const TAX_CLASS = EugeneEmployer::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    public function testTax(): void
    {
        $this->validate(
            (new IncomeParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(null)
                ->build()
        );
    }
}
