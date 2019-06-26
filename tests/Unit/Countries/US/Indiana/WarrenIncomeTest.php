<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\WarrenIncome\WarrenIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class WarrenIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * from Indiana tax calculation: 300 taxable wages
     * round(300 * .0212) = 6.36 tax
     */
    public function testWarrenIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 86,
            'county_worked' => 85,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.warren'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.warren'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(6.36, self::identicalTo($results->getTax(WarrenIncome::class)));
    }

    public function testWarrenIncomeCountyWorked(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 0,
            'county_worked' => 86,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.warren'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.warren'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(6.36, self::identicalTo($results->getTax(WarrenIncome::class)));
    }
}
