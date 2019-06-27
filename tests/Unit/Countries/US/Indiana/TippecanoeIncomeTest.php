<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\TippecanoeIncome\TippecanoeIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class TippecanoeIncomeTest extends TestCase
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
     * Tax Due                  $2.45
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 2 dependent exemptions * 1500 = 3000
     * 4000 total allowances / 52 weeks = 76.923077
     * 300 - 76.923077 = 223.07692 taxable wages
     * round(223.07692 * .011) = 2.45 tax
     */
    public function testTippecanoeIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 1,
            'dependent_exemptions' => 2,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 79,
            'county_worked' => 78,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.tippecanoe'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.tippecanoe'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(2.45, self::identicalTo($results->getTax(TippecanoeIncome::class)));
    }

    public function testTippecanoeIncomeCountyWorked(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 1,
            'dependent_exemptions' => 2,
            'exempt' => false,
            'additional_withholding' => 0,
            'county_lived' => 0,
            'county_worked' => 79,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.tippecanoe'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.tippecanoe'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(2.45, self::identicalTo($results->getTax(TippecanoeIncome::class)));
    }
}
