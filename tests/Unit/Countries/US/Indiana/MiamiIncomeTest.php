<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\MiamiIncome\MiamiIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class MiamiIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Weekly Pay               $300.00
     * Personal Exemptions      2
     * Dependent Exemptions     1
     * Tax Due                  $5.91
     *
     * Math:
     * 2 personal exemptions * 1000 = 2000
     * 1 dependent exemptions * 1500 = 1500
     * 3500 total allowances / 52 weeks = 67.307692
     * 300 - 67.307692 = 232.69231 taxable wages
     * round(232.69231 * .0254) = 5.91 tax
     */
    public function testMiamiIncome(): void
    {
        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => 2,
            'dependent_exemptions' => 1,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 52,
            'county_worked' => 51,
        ]);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.miami'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.miami'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(5.91, self::identicalTo($results->getTax(MiamiIncome::class)));
    }

    public function testMiamiIncomeCountyWorked(): void
    {
        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => 2,
            'dependent_exemptions' => 1,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 0,
            'county_worked' => 52,
        ]);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.miami'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.miami'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(5.91, self::identicalTo($results->getTax(MiamiIncome::class)));
    }
}
