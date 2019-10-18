<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\BessemerOccupational\BessemerOccupational;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class BessemerOccupationalTest extends TaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(BessemerOccupational::class);
    }

    public function testBessemerOccupational(): void
    {
        $this->validate(
            (new IncomeParametersBuilder())
                ->setDate('2017-01-01')
                ->setHomeLocation('us.alabama.bessemer')
                ->setTaxClass(BessemerOccupational::class)
                ->setWagesInCents(230000)
                ->setPayPeriods(1)
                ->setExpectedAmountInCents(2300)
                ->build()
        );
    }
}
