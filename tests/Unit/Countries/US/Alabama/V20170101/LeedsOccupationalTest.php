<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\LeedsOccupational\LeedsOccupational;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class LeedsOccupationalTest extends TaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(LeedsOccupational::class);
    }

    public function testLeedsOccupational(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate('2017-01-01')
                ->setHomeLocation('us.alabama.leeds')
                ->setTaxClass(LeedsOccupational::class)
                ->setWagesInCents(230000)
                ->setPayPeriods(1)
                ->setExpectedAmountInCents(2300)
                ->build()
        );
    }
}
