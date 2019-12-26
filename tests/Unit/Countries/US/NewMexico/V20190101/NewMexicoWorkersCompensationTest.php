<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewMexico\V20190101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoWorkersCompensation\NewMexicoWorkersCompensation;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewMexicoWorkersCompensationTest extends TaxTestCase
{
    private const DATE = '2019-03-31';
    private const LOCATION = 'us.new_mexico';
    private const TAX_CLASS = NewMexicoWorkersCompensation::class;

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
                ->setWagesInCents(10000)
                ->setExpectedAmountInCents(230)
                ->build()
        );
    }
}
