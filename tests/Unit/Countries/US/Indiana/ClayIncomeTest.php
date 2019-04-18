<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\ClayIncome\ClayIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class ClayIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Weekly Pay               $300.00
     * Personal Exemptions      1
     * Dependent Exemptions     1
     * Tax Due                  $5.67
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 1 dependent exemptions * 1500 = 1500
     * 2500 total allowances / 52 weeks = 48.0769
     * 300 - 48.0769 = 251.9231 taxable wages
     * round(251.9231 * .0225) = 5.67 tax
     */
    public function testClayIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 1,
            'dependent_exemptions' => 1,
            'exempt' => false,
            'additional_withholding' => 0,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.clay'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.clay'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(5.66, self::identicalTo($results->getTax(ClayIncome::class)));
    }
}
