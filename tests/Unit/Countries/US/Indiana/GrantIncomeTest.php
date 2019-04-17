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
     * Personal Exemptions      1
     * Dependent Exemptions     2
     * Tax Due                  $5.69
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 2 dependent exemptions * 1500 = 3000
     * 4000 total allowances / 52 weeks = 76.9231
     * 300 - 76.9231 = 223.0769 taxable wages
     * round(223.0769 * .0255) = 5.69 tax
     */
    public function testGrantIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 1,
            'dependent_exemptions' => 2,
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

        $this->assertThat(5.68, self::identicalTo($results->getTax(GrantIncome::class)));
    }
}
