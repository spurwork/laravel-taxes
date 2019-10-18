<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Massachusetts\V20190101;

use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeaveEmployer\MassachusettsFamilyMedicalLeaveEmployer;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MassachusettsFamilyMedicalLeaveEmployerTest extends TaxTestCase
{
    private const DATE = '2019-09-30';
    private const LOCATION = 'us.massachusetts';
    private const TAX_CLASS = MassachusettsFamilyMedicalLeaveEmployer::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    public function testTax(): void
    {
        $this->validate(
            (new IncomeParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(230000)
                ->setExpectedAmountInCents(null)
                ->build()
        );
    }
}
