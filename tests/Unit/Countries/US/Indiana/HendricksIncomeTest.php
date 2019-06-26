<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\HendricksIncome\HendricksIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class HendricksIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * from Indiana tax calculation: 300 taxable wages
     * round(300 * .015) = 4.50 tax
     */
    public function testHendricksIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 32,
            'county_worked' => 31,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.hendricks'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.hendricks'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(4.50, self::identicalTo($results->getTax(HendricksIncome::class)));
    }

    public function testHendricksIncomeCountyWorked(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 0,
            'county_worked' => 32,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.hendricks'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.hendricks'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(4.50, self::identicalTo($results->getTax(HendricksIncome::class)));
    }
}
