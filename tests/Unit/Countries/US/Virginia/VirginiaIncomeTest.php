<?php

namespace Appleton\Taxes\Unit\Countries\US\Virginia;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Virginia\VirginiaIncome\VirginiaIncome;
use Appleton\Taxes\Models\Countries\US\Virginia\VirginiaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class VirginiaIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Test Case 1
     * Weekly Pay               $300.00
     * Exemptions               0
     * 65+/Blind Exemptions     0
     * Tax Due                  $8.17
     *
     * Math:
     * 300 wages * 52 weeks= 15600 gross
     * 0 personal exemptions * 930 = 0
     * 0 other exemptions * 800 = 0
     * 15600 - 4500 - 0 - 0 = 11100 taxable
     * falls in 5000 - 17000 bracket
     * 11100 - 5000 = 6100 in excess of 5k
     * 120 + 6100 * .05 = 425 annual
     * round(425 / 52 weeks) = 8.17 tax
     */
    public function testVirginiaIncome_testCase1(): void
    {
        $results = $this->calculateTaxes(0, 0, 300.0);
        $this->assertThat(8.17, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 2
     * Weekly Pay               $300.00
     * Exemptions               2
     * 65+/Blind Exemptions     0
     * Tax Due                  $6.38
     *
     * Math:
     * 300 wages * 52 weeks= 15600 gross
     * 2 personal exemptions * 930 = 1860
     * 0 other exemptions * 800 = 0
     * 15600 - 4500 - 1860 - 0 = 9240 taxable
     * falls in 5000 - 17000 bracket
     * 9240 - 5000 = 4240 in excess of 5k
     * 120 + 4240 * .05 = 332 annual tax
     * round(332 / 52 weeks) = 6.38 tax
     */
    public function testVirginiaIncome_testCase2(): void
    {
        $results = $this->calculateTaxes(2, 0, 300.0);
        $this->assertThat(6.38, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 3
     * Weekly Pay               $300.00
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Tax Due                  $4.84
     *
     * Math:
     * 300 wages * 52 weeks= 15600 gross
     * 2 personal exemptions * 930 = 1860
     * 2 other exemptions * 800 = 1600
     * 15600 - 4500 - 1860 - 1600 = 7640 taxable
     * falls in 5000 - 17000 bracket
     * 7640 - 5000 = 4140 in excess of 5k
     * 120 + 4140 * .05 = 252 0 annual tax
     * round(252 / 52 weeks) = 4.84 tax
     */
    public function testVirginiaIncome_testCase3(): void
    {
        $results = $this->calculateTaxes(2, 2, 300.0);
        $this->assertThat(4.84, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 4
     * Weekly Pay               $134.62
     * Exemptions               0
     * 65+/Blind Exemptions     0
     * Tax Due                  $0.96
     *
     * Math:
     * 134.62 wages * 52 weeks= 7002.24 gross
     * 0 personal exemptions * 930 = 0
     * 0 other exemptions * 800 = 0
     * 7002.24 - 4500 - 0 - 0 = 2502.24 taxable
     * falls in 3000 - 5000 bracket
     * 2502.24 * .02 = 50.04 annual tax
     * round(50.04 / 52 weeks) = 0.96 tax
     */
    public function testVirginiaIncome_testCase4(): void
    {
        $results = $this->calculateTaxes(0, 0, 134.62);
        $this->assertThat(0.96, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 5
     * Weekly Pay               $173.07
     * Exemptions               2
     * 65+/Blind Exemptions     0
     * Tax Due                  $1.01
     *
     * Math:
     * 173.07 wages * 52 weeks= 8999.61 gross
     * 2 personal exemptions * 930 = 1860
     * 0 other exemptions * 800 = 0
     * 8999.61 - 4500 - 1860 - 0 = 2639.61 taxable
     * 2639.61 * .02 = 52.76 annual tax
     * round(52.76 / 52 weeks) = 1.01 tax
     */
    public function testVirginiaIncome_testCase5(): void
    {
        $results = $this->calculateTaxes(2, 0, 173.07);
        $this->assertThat(1.01, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 6
     * Weekly Pay               $211.54
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Tax Due                  $1.17
     *
     * Math:
     * 211.54 wages * 52 weeks= 11000.08 gross
     * 2 personal exemptions * 930 = 1860
     * 2 other exemptions * 800 = 1600
     * 11000.08 - 4500 - 1860 - 1600 = 3040.08 taxable
     * falls in 3000 - 5000 bracket
     * 3040.08 - 3000 = 40.08 in excess of 3k
     * 60 + 1540.08 * .03 = 61.20 annual tax
     * round(61.20 / 52 weeks) = 1.17 tax
     */
    public function testVirginiaIncome_testCase6(): void
    {
        $results = $this->calculateTaxes(2, 2, 211.54);
        $this->assertThat(1.17, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 7
     * Weekly Pay               $961.54
     * Exemptions               0
     * 65+/Blind Exemptions     0
     * Tax Due                  $45.36
     *
     * Math:
     * 961.54 wages * 52 weeks= 50000.08 gross
     * 0 personal exemptions * 930 = 0
     * 0 other exemptions * 800 = 0
     * 50000.08 - 4500 - 0 - 0 = 45500.08 taxable
     * falls in 17000+ bracket
     * 45500.08 - 17000 = 28500.08 in excess of 17k
     * 720 + 28500.08 * .0575 = 2358.75 annual tax
     * round(2358.75 / 52 weeks) = 45.36 tax
     */
    public function testVirginiaIncome_testCase7(): void
    {
        $results = $this->calculateTaxes(0, 0, 961.54);
        $this->assertThat(45.36, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 8
     * Weekly Pay               $961.54
     * Exemptions               2
     * 65+/Blind Exemptions     0
     * Tax Due                  $43.30
     *
     * Math:
     * 961.54 wages * 52 weeks= 50000.08 gross
     * 2 personal exemptions * 930 = 1860
     * 0 other exemptions * 800 = 0
     * 50000.08 - 4500 - 1860 - 0 = 43640.08 taxable
     * falls in 17000+ bracket
     * 43640.08 - 17000 = 26640.08 in excess of 17k
     * 720 + 26640.08 * .0575 = 2251.80 annual tax
     * round(2251.80 / 52 weeks) = 43.30 tax
     */
    public function testVirginiaIncome_testCase8(): void
    {
        $results = $this->calculateTaxes(2, 0, 961.54);
        $this->assertThat(43.30, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 9
     * Weekly Pay               $961.54
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Tax Due                  $41.53
     *
     * Math:
     * 961.54 wages * 52 weeks= 50000.08 gross
     * 2 personal exemptions * 930 = 1860
     * 2 other exemptions * 800 = 1600
     * 50000.08 - 4500 - 1860 - 1600 = 42040.08 taxable
     * falls in 17000+ bracket
     * 42040.08 - 17000 = 26540.08 in excess of 17k
     * 720 + 26540.08 * .0575 = 2159.80 annual tax
     * round(2159.80 / 52 weeks) = 41.53 tax
     */
    public function testVirginiaIncome_testCase9(): void
    {
        $results = $this->calculateTaxes(2, 2, 961.54);
        $this->assertThat(41.53, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 10
     * Weekly Pay               $100.00
     * Exemptions               0
     * 65+/Blind Exemptions     0
     * Tax Due                  $0.26
     *
     * Math:
     * 100.00 wages * 52 weeks= 5200.00 gross
     * 0 personal exemptions * 930 = 0
     * 0 other exemptions * 800 = 0
     * 5200.00 - 4500 - 0 - 0 = 700 taxable
     * falls in 3000- bracket
     * 700 * .02 = 14 annual tax
     * round(14 / 52 weeks) = 0.26 tax
     */
    public function testVirginiaIncome_testCase10(): void
    {
        $results = $this->calculateTaxes(0, 0, 100.0);
        $this->assertThat(0.26, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 11
     * Weekly Pay               $100.00
     * Exemptions               2
     * 65+/Blind Exemptions     0
     * Tax Due                  $0.0
     *
     * Math:
     * 100.00 wages * 52 weeks= 5200 gross
     * 2 personal exemptions * 930 = 1860
     * 0 other exemptions * 800 = 0
     * 5200.00 - 4500 - 1860 - 0 = -1160 taxable
     * 0 tax
     */
    public function testVirginiaIncome_testCase11(): void
    {
        $results = $this->calculateTaxes(2, 0, 100.0);
        $this->assertThat(null, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 12
     * Weekly Pay               $130.00
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Tax Due                  $0
     *
     * Math:
     * 100.00 wages * 52 weeks= 5200 gross
     * 2 personal exemptions * 930 = 1860
     * 2 other exemptions * 800 = 1600
     * 5200.00 - 4500 - 1860 - 0 = 0 taxable
     * 0 tax
     */
    public function testVirginiaIncome_testCase12(): void
    {
        $results = $this->calculateTaxes(2, 2, 130.0);
        $this->assertThat(null, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 13
     * Weekly Pay               $300.00
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Exempt                   true
     * Tax Due                  $0.00
     */
    public function testVirginiaIncome_testCase13(): void
    {
        $results = $this->calculateTaxes(2, 2, 300.0, true);
        $this->assertThat(null, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    private function calculateTaxes(
        int $exemptions,
        int $other_exemptions,
        float $earnings,
        bool $exempt = false
    ): TaxResults {
        VirginiaIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $exemptions,
            'sixty_five_plus_or_blind_exemptions' => $other_exemptions,
            'exempt' => $exempt,
        ]);

        return $this->taxes->calculate(function (Taxes $taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.virginia'));
            $taxes->setWorkLocation($this->getLocation('us.virginia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });
    }
}
