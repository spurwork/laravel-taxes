<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\HobsonCityOccupational\HobsonCityOccupational;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class HobsonCityOccupationalTest extends TaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(HobsonCityOccupational::class);
    }

    public function testHobsonCityOccupational(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate('2017-01-01')
                ->setHomeLocation('us.alabama.hobsoncity')
                ->setTaxClass(HobsonCityOccupational::class)
                ->setWagesInCents(230000)
                ->setPayPeriods(1)
                ->setExpectedAmountInCents(4600)
                ->build()
        );
    }
}
