<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\GreeneIncome\GreeneIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class GreeneIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Weekly Pay               $300.00
     * Personal Exemptions      1
     * Dependent Exemptions     2
     * Tax Due                  $3.90
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 2 dependent exemptions * 1500 = 3000
     * 4000 total allowances / 52 weeks = 76.923077
     * 300 - 76.923077 = 223.07692 taxable wages
     * round(223.07692 * .0175) = 3.90 tax
     */
    public function testGreeneIncome(): void
    {
        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => 2,
            'dependent_exemptions' => 1,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 28,
            'county_worked' => 27,
        ]);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.greene'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.greene'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(4.07, self::identicalTo($results->getTax(GreeneIncome::class)));
    }

    public function testGreeneIncomeCountyWorked(): void
    {
        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => 2,
            'dependent_exemptions' => 1,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 0,
            'county_worked' => 28,
        ]);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.greene'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.greene'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(4.07, self::identicalTo($results->getTax(GreeneIncome::class)));
    }
}
