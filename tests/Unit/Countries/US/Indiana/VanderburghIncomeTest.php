<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\VanderburghIncome\VanderburghIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class VanderburghIncomeTest extends TestCase
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
     * Tax Due                  $3.37
     *
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 0 dependent exemptions * 1500 = 0
     * 1000 total allowances / 52 weeks = 19.230769
     * 300 - 19.230769 = 280.76923 taxable wages
     * round(280.76923 * .012) = 3.37 tax
     */
    public function testVanderburghIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 1,
            'dependent_exemptions' => 0,
            'exempt' => false,
            'additional_withholding' => 0,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.vanderburgh'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.vanderburgh'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(3.36, self::identicalTo($results->getTax(VanderburghIncome::class)));
    }
}
