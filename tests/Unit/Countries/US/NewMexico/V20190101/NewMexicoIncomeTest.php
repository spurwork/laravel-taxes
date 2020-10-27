<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewMexico\V20190101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome;
use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewMexicoIncomeTest extends TaxTestCase
{
    private const DATE = '2018-01-01';
    private const LOCATION = 'us.new_mexico';
    private const TAX_CLASS = NewMexicoIncome::class;
    private const TAX_INFO_CLASS = NewMexicoIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        NewMexicoIncomeTaxInformation::createForUser([
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
            'exemptions' => 0,
            'additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);
    }

    public function testTax(): void
    {
        $this->validate(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setTaxInfoClass(self::TAX_INFO_CLASS)
                ->setPayPeriods(52)
                ->setWagesInCents(10000)
                ->setExpectedAmountInCents(49)
                ->build()
        );
    }
}
