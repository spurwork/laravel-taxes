<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Indiana\MartinIncome\MartinIncome;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class MartinIncomeTest extends TestCase
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
     * Tax Due                  $4.41
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 1 dependent exemptions * 1500 = 1500
     * 2500 total allowances / 52 weeks = 48.0769
     * 300 - 48.0769 = 251.9231 taxable wages
     * round(251.9231 * .0175) = 4.41 tax
     */
    public function testMartinIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 1,
            'dependent_exemptions' => 1,
            'exempt' => false,
            'additional_withholding' => 0,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.martin'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.martin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(4.40, self::identicalTo($results->getTax(MartinIncome::class)));
    }
}
