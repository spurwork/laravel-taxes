<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\SouthsideOccupational\SouthsideOccupational;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class SouthsideOccupationalTest extends TaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(SouthsideOccupational::class);
    }

    public function testSouthsideOccupational(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate('2017-01-01')
                ->setHomeLocation('us.alabama.southside')
                ->setTaxClass(SouthsideOccupational::class)
                ->setWagesInCents(230000)
                ->setPayPeriods(1)
                ->setExpectedAmountInCents(4600)
                ->build()
        );
    }
}
