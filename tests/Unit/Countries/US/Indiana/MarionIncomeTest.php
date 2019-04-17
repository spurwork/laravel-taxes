<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\MarionIncome\MarionIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class MarionIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Weekly Pay               $300.00
     * Personal Exemptions      1
     * Dependent Exemptions     0
     * Tax Due                  $5.67
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 0 dependent exemptions * 1500 = 0
     * 1000 total allowances / 52 weeks = 19.2308
     * 300 - 19.2308 = 280.7692 taxable wages
     * round(280.7692 * .0202) = 5.67 tax
     */
    public function testMarionIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 1,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.marion'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.marion'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(5.67, self::identicalTo($results->getTax(MarionIncome::class)));
    }
}
