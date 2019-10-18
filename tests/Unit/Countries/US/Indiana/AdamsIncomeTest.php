<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\AdamsIncome\AdamsIncome;
use Appleton\Taxes\Countries\US\Indiana\AllenIncome\AllenIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Illinois\IllinoisIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class AdamsIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * from Indiana tax calculation: 300 taxable wages
     * round(300 * .01624) = 4.87 tax
     */
    public function testAdamsIncomeCountyLived(): void
    {
        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 1,
            'county_worked' => 3,
        ]);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana'));
            $taxes->setWorkLocation($this->getLocation('us.indiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(9.69, self::identicalTo($results->getTax(IndianaIncome::class)));
        $this->assertThat(4.87, self::identicalTo($results->getTax(AdamsIncome::class)));
        $this->assertThat(null, self::identicalTo($results->getTax(AllenIncome::class)));
    }

    public function testAdamsIncomeCountyWorked(): void
    {
        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 0,
            'county_worked' => 1,
        ]);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana'));
            $taxes->setWorkLocation($this->getLocation('us.indiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(9.69, self::identicalTo($results->getTax(IndianaIncome::class)));
        $this->assertThat(4.87, self::identicalTo($results->getTax(AdamsIncome::class)));
    }
}
