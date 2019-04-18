<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\GrantIncome\GrantIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class GrantIncomeTest extends TestCase
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
     * Tax Due                  $5.93
     *
     * Math:
     * 2 personal exemptions * 1000 = 2000
     * 1 dependent exemptions * 1500 = 1500
     * 3500 total allowances / 52 weeks = 67.307692
     * 300 - 67.307692 = 232.69231 taxable wages
     * round(232.69231 * .0255) = 5.93 tax
     */
    public function testGrantIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 2,
            'dependent_exemptions' => 1,
            'exempt' => false,
            'additional_withholding' => 0,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.grant'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.grant'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(5.93, self::identicalTo($results->getTax(GrantIncome::class)));
    }
}
