<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Oregon\V20200101\TransitDistrictTaxes;

use Appleton\Taxes\Countries\US\Oregon\TransitDistrictTaxes\LaneCountyEmployer\LaneCountyEmployer;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\US\Oregon\TransitDistrictTaxesTestCase;

class LaneCountyEmployerTest extends TransitDistrictTaxesTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.oregon';
    private const TAX_CLASS = LaneCountyEmployer::class;

    public function testTax(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setAdditionalTax(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(30000)
                ->setExpectedAmountInCents(225)
                ->build()
        );
    }
}
