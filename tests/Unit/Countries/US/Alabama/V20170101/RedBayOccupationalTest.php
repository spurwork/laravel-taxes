<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\RedBayOccupational\RedBayOccupational;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class RedBayOccupationalTest extends TaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(RedBayOccupational::class);
    }

    public function testRedBayOccupational(): void
    {
        $this->validate(
            (new IncomeParametersBuilder())
                ->setDate('2017-01-01')
                ->setHomeLocation('us.alabama.redbay')
                ->setTaxClass(RedBayOccupational::class)
                ->setWagesInCents(230000)
                ->setPayPeriods(1)
                ->setExpectedAmountInCents(1150)
                ->build()
        );
    }
}
