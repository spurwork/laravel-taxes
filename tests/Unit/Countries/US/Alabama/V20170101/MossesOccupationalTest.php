<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\MossesOccupational\MossesOccupational;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MossesOccupationalTest extends TaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(MossesOccupational::class);
    }

    public function testMossesOccupational(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate('2017-01-01')
                ->setHomeLocation('us.alabama.mosses')
                ->setTaxClass(MossesOccupational::class)
                ->setWagesInCents(230000)
                ->setPayPeriods(1)
                ->setExpectedAmountInCents(2300)
                ->build()
        );
    }
}
