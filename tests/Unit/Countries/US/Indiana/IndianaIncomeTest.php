<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Classes\WorkerTaxes\TaxResults;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class IndianaIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Test Case 1
     * Weekly Pay               $300.00
     * Personal Exemptions      1
     * Dependent Exemptions     0
     * Tax Due                  $9.07
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 0 dependent exemptions * 1500 = 0
     * 1000 total allowances / 52 weeks = 19.2308
     * 300 - 19.2308 = 280.7692 taxable wages
     * round(280.7692 * .0323) = 9.07 tax
     */
    public function testIndianaIncome_testCase1(): void
    {
        $results = $this->calculateTaxes(300.0, 1, 0);
        $this->assertThat(9.06, self::identicalTo($results->getTax(IndianaIncome::class)));
    }

    /**
     * Test Case 2
     * Weekly Pay               $300.00
     * Personal Exemptions      1
     * Dependent Exemptions     1
     * Tax Due                  $8.14
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 1 dependent exemptions * 1500 = 1500
     * 2500 total allowances / 52 weeks = 48.0769
     * 300 - 48.0769 = 251.9231 taxable wages
     * round(251.9231 * .0323) = 8.14 tax
     */
    public function testIndianaIncome_testCase2(): void
    {
        $results = $this->calculateTaxes(300.0, 1, 1);
        $this->assertThat(8.13, self::identicalTo($results->getTax(IndianaIncome::class)));
    }

    /**
     * Test Case 3
     * Weekly Pay               $300.00
     * Personal Exemptions      1
     * Dependent Exemptions     2
     * Tax Due                  $7.21
     *
     * Math:
     * 1 personal exemptions * 1000 = 1000
     * 2 dependent exemptions * 1500 = 3000
     * 4000 total allowances / 52 weeks = 76.9231
     * 300 - 76.9231 = 223.0769 taxable wages
     * round(223.0769 * .0323) = 7.52 tax
     */
    public function testIndianaIncome_testCase3(): void
    {
        $results = $this->calculateTaxes(300.0, 1, 2);
        $this->assertThat(7.20, self::identicalTo($results->getTax(IndianaIncome::class)));
    }

    /**
     * Test Case 4
     * Weekly Pay               $300.00
     * Personal Exemptions      2
     * Dependent Exemptions     1
     * Tax Due                  $7.52
     *
     * Math:
     * 2 personal exemptions * 1000 = 2000
     * 1 dependent exemptions * 1500 = 1500
     * 3500 total allowances / 52 weeks = 67.3077
     * 300 - 67.3077 = 232.6923 taxable wages
     * round(232.6923 * .0323) = 7.52 tax
     */
    public function testIndianaIncome_testCase4(): void
    {
        $results = $this->calculateTaxes(300.0, 2, 1);
        $this->assertThat(7.51, self::identicalTo($results->getTax(IndianaIncome::class)));
    }

    /**
     * Test Case 5
     * Weekly Pay               $300.00
     * Personal Exemptions      0
     * Dependent Exemptions     1
     * Tax Due                  $8.76
     *
     * Math:
     * 0 personal exemptions * 1000 = 0
     * 1 dependent exemptions * 1500 = 1500
     * 1500 total allowances / 52 weeks = 23.8462
     * 300 - 23.8462 = 271.1539 taxable wages
     * round(271.1539 * .0323) = 8.76 tax
     */
    public function testIndianaIncome_testCase5(): void
    {
        $results = $this->calculateTaxes(300.0, 0, 1);
        $this->assertThat(8.75, self::identicalTo($results->getTax(IndianaIncome::class)));
    }

    /**
     * Exempt
     * Weekly Pay               $300.00
     * Tax Due                  $0.00
     */
    public function testIndianaIncome_exempt(): void
    {
        $results = $this->calculateTaxes(300.0, 0, 0, true);
        $this->assertThat(null, self::identicalTo($results->getTax(IndianaIncome::class)));
    }

    /**
     * Additional Withholding
     * Weekly Pay               $300.00
     * Basic Allowances         0
     * Additional Allowances    0
     * Additional Withholding   $10.00
     * Tax Due                  $19.69
     *
     * Math:
     * 0 personal exemptions * 1000 = 0
     * 0 dependent exemptions * 1500 = 0
     * 0 total allowances / 52 weeks = 0
     * 300 - 0 = 300 taxable wages
     * round(300 * .0323) = 9.69
     * 9.69 + 10.00 additional withholding - 19.69 tax
     */
    public function testIndianaIncome_additionalWithholding(): void
    {
        $results = $this->calculateTaxes(300.0, 0, 0, false, 10.0);
        $this->assertThat(19.69, self::identicalTo($results->getTax(IndianaIncome::class)));
    }

    private function calculateTaxes(int $earnings, int $personal_exemptions, int $dependent_exemptions,
                                    bool $exempt = false, int $additional_withholding = 0): TaxResults
    {
        IndianaIncomeTaxInformation::forUser($this->user)->update([
            'personal_exemptions' => $personal_exemptions,
            'dependent_exemptions' => $dependent_exemptions,
            'exempt' => $exempt,
            'additional_withholding' => $additional_withholding,
            'county_lived' => 22,
            'county_worked' => 33,
        ]);

        return $this->taxes->calculate(function (Taxes $taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.indiana'));
            $taxes->setWorkLocation($this->getLocation('us.indiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });
    }
}
