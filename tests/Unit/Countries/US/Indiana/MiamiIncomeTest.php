<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
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
     * Personal Exemptions      1
     * Dependent Exemptions     2
     * Tax Due                  $5.67
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 2 dependent exemptions * 1500 = 3000
     * 4000 total allowances / 52 weeks = 76.9231
     * 300 - 76.9231 = 223.0769 taxable wages
     * round(223.0769 * .0254) = 5.67 tax
     */
    public function testMiamiIncome(): void
    {
        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 1,
            'dependent_exemptions' => 2,
            'exempt' => false,
            'additional_withholding' => 0,
        ], $this->user);

        $results = $this->taxes->calculate(function (Taxes $taxes) {
            $taxes->setHomeLocation($this->getLocation('us.indiana.miami'));
            $taxes->setWorkLocation($this->getLocation('us.indiana.miami'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertThat(5.66, self::identicalTo($results->getTax(MiamiIncome::class)));
    }
}
