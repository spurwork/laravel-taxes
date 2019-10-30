<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Massachusetts\V20191001;

use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeave\MassachusettsFamilyMedicalLeave;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MassachusettsFamilyMedicalLeaveTest extends TaxTestCase
{
    private const DATE = '2019-10-01';
    private const LOCATION = 'us.massachusetts';
    private const TAX_CLASS = MassachusettsFamilyMedicalLeave::class;

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
                ->setWagesInCents(230000)
                ->setExpectedAmountInCents(869)
                ->build()
        );
    }
}
