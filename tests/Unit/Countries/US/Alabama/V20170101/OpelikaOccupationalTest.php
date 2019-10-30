<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\OpelikaOccupational\OpelikaOccupational;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class OpelikaOccupationalTest extends TaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(OpelikaOccupational::class);
    }

    public function testOpelikaOccupational(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate('2017-01-01')
                ->setHomeLocation('us.alabama.opelika')
                ->setTaxClass(OpelikaOccupational::class)
                ->setWagesInCents(230000)
                ->setPayPeriods(1)
                ->setExpectedAmountInCents(3450)
                ->build()
        );
    }
}
