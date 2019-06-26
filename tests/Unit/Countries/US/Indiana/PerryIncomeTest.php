<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\PerryIncome\PerryIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class PerryIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * from Indiana tax calculation: 300 taxable wages
     * round(300 * .0181) = 5.43 tax
     */
    public function testPerryIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 62,
            'county_worked' => 61,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.perry'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.perry'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(5.43, self::identicalTo($results->getTax(PerryIncome::class)));
    }

    public function testPerryIncomeCountyWorked(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 0,
            'county_worked' => 62,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.perry'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.perry'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(5.43, self::identicalTo($results->getTax(PerryIncome::class)));
    }
}
