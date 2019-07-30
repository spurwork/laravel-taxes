<?php

namespace Appleton\Taxes\Unit\Countries\US\Virginia;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Classes\TaxResults;
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
     * Tax Due                  $9.61
     *
     * Math:
     * 300 wages * 52 weeks= 15600 gross
     * 0 personal exemptions * 930 = 0
     * 0 other exemptions * 800 = 0
     * 15600 - 3000 - 0 - 0 = 12600 taxable
     * falls in 5000 - 17000 bracket
     * 12600 - 5000 = 7600 in excess of 5k
     * 120 + 7600 * .05 = 500 annual
     * round(500 / 52 weeks) = 9.61 tax
     */
    public function testVirginiaIncome_testCase1(): void
    {
        $results = $this->calculateTaxes(0, 0, 300.0);
        $this->assertThat(9.61, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 2
     * Weekly Pay               $300.00
     * Exemptions               2
     * 65+/Blind Exemptions     0
     * Tax Due                  $7.82
     *
     * Math:
     * 300 wages * 52 weeks= 15600 gross
     * 2 personal exemptions * 930 = 1860
     * 0 other exemptions * 800 = 0
     * 15600 - 3000 - 1860 - 0 = 10740 taxable
     * falls in 5000 - 17000 bracket
     * 10740 - 5000 = 5740 in excess of 5k
     * 120 + 5740 * .05 = 407 annual tax
     * round(407 / 52 weeks) = 7.82 tax
     */
    public function testVirginiaIncome_testCase2(): void
    {
        $results = $this->calculateTaxes(2, 0, 300.0);
        $this->assertThat(7.82, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 3
     * Weekly Pay               $300.00
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Tax Due                  $6.29
     *
     * Math:
     * 300 wages * 52 weeks= 15600 gross
     * 2 personal exemptions * 930 = 1860
     * 2 other exemptions * 800 = 1600
     * 15600 - 3000 - 1860 - 1600 = 9140 taxable
     * falls in 5000 - 17000 bracket
     * 9140 - 5000 = 4140 in excess of 5k
     * 120 + 4140 * .05 = 327 0 annual tax
     * round(327 / 52 weeks) = 6.29 tax
     */
    public function testVirginiaIncome_testCase3(): void
    {
        $results = $this->calculateTaxes(2, 2, 300.0);
        $this->assertThat(6.28, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 4
     * Weekly Pay               $134.62
     * Exemptions               0
     * 65+/Blind Exemptions     0
     * Tax Due                  $1.73
     *
     * Math:
     * 134.62 wages * 52 weeks= 7002.24 gross
     * 0 personal exemptions * 930 = 0
     * 0 other exemptions * 800 = 0
     * 7002.24 - 3000 - 0 - 0 = 4002.24 taxable
     * falls in 3000 - 5000 bracket
     * 4002.24 - 3000 = 1002.24 in excess of 3k
     * 60 + 1002.24 * .03 = 90.0672 annual tax
     * round(0.0672 / 52 weeks) = 1.73 tax
     */
    public function testVirginiaIncome_testCase4(): void
    {
        $results = $this->calculateTaxes(0, 0, 134.62);
        $this->assertThat(1.73, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 5
     * Weekly Pay               $173.07
     * Exemptions               2
     * 65+/Blind Exemptions     0
     * Tax Due                  $1.81
     *
     * Math:
     * 173.07 wages * 52 weeks= 8999.61 gross
     * 2 personal exemptions * 930 = 1860
     * 0 other exemptions * 800 = 0
     * 8999.61 - 3000 - 1860 - 0 = 4139.61 taxable
     * falls in 3000 - 5000 bracket
     * 4139.61 - 3000 = 1139.61 in excess of 3k
     * 60 + 1139.61 * .03 = 94.1883 annual tax
     * round(94.1883 / 52 weeks) = 1.81 tax
     */
    public function testVirginiaIncome_testCase5(): void
    {
        $results = $this->calculateTaxes(2, 0, 173.07);
        $this->assertThat(1.81, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 6
     * Weekly Pay               $211.54
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Tax Due                  $2.04
     *
     * Math:
     * 211.54 wages * 52 weeks= 11000.08 gross
     * 2 personal exemptions * 930 = 1860
     * 2 other exemptions * 800 = 1600
     * 8999.61 - 3000 - 1860 - 1600 = 4540.08 taxable
     * falls in 3000 - 5000 bracket
     * 4540.08 - 3000 = 1540.08 in excess of 3k
     * 60 + 1540.08 * .03 = 106.2024 annual tax
     * round(106.2024 / 52 weeks) = 2.04 tax
     */
    public function testVirginiaIncome_testCase6(): void
    {
        $results = $this->calculateTaxes(2, 2, 211.54);
        $this->assertThat(2.04, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 7
     * Weekly Pay               $961.54
     * Exemptions               0
     * 65+/Blind Exemptions     0
     * Tax Due                  $47.02
     *
     * Math:
     * 961.54 wages * 52 weeks= 50000.08 gross
     * 0 personal exemptions * 930 = 0
     * 0 other exemptions * 800 = 0
     * 50000.08 - 3000 - 0 - 0 = 47000.08 taxable
     * falls in 17000+ bracket
     * 47000.08 - 17000 = 30000.08 in excess of 17k
     * 720 + 30000.08 * .0575 = 2445.0046 annual tax
     * round(2445.0046 / 52 weeks) = 47.02 tax
     */
    public function testVirginiaIncome_testCase7(): void
    {
        $results = $this->calculateTaxes(0, 0, 961.54);
        $this->assertThat(47.01, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 8
     * Weekly Pay               $961.54
     * Exemptions               2
     * 65+/Blind Exemptions     0
     * Tax Due                  $44.96
     *
     * Math:
     * 961.54 wages * 52 weeks= 50000.08 gross
     * 2 personal exemptions * 930 = 1860
     * 0 other exemptions * 800 = 0
     * 50000.08 - 3000 - 1860 - 0 = 45140.08 taxable
     * falls in 17000+ bracket
     * 45140.08 - 17000 = 28140.08 in excess of 17k
     * 720 + 28140.08 * .0575 = 2338.0546 annual tax
     * round(2338.0546 / 52 weeks) = 44.96 tax
     */
    public function testVirginiaIncome_testCase8(): void
    {
        $results = $this->calculateTaxes(2, 0, 961.54);
        $this->assertThat(44.96, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 9
     * Weekly Pay               $961.54
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Tax Due                  $43.19
     *
     * Math:
     * 961.54 wages * 52 weeks= 50000.08 gross
     * 2 personal exemptions * 930 = 1860
     * 2 other exemptions * 800 = 1600
     * 50000.08 - 3000 - 1860 - 1600 = 43540.08 taxable
     * falls in 17000+ bracket
     * 45140.08 - 17000 = 26540.08 in excess of 17k
     * 720 + 26540.08 * .0575 = 2246.0546 annual tax
     * round(2246.0546 / 52 weeks) = 43.19 tax
     */
    public function testVirginiaIncome_testCase9(): void
    {
        $results = $this->calculateTaxes(2, 2, 961.54);
        $this->assertThat(43.19, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 10
     * Weekly Pay               $100.00
     * Exemptions               0
     * 65+/Blind Exemptions     0
     * Tax Due                  $0.85
     *
     * Math:
     * 100.00 wages * 52 weeks= 5200.00 gross
     * 0 personal exemptions * 930 = 0
     * 0 other exemptions * 800 = 0
     * 5200.00 - 3000 - 0 - 0 = 2200 taxable
     * falls in 3000- bracket
     * 2200 * .02 = 44 annual tax
     * round(44 / 52 weeks) = 0.85 tax
     */
    public function testVirginiaIncome_testCase10(): void
    {
        $results = $this->calculateTaxes(0, 0, 100.0);
        $this->assertThat(0.84, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 11
     * Weekly Pay               $100.00
     * Exemptions               2
     * 65+/Blind Exemptions     0
     * Tax Due                  $0.13
     *
     * Math:
     * 100.00 wages * 52 weeks= 5200 gross
     * 2 personal exemptions * 930 = 1860
     * 0 other exemptions * 800 = 0
     * 5200.00 - 3000 - 1860 - 0 = 340 taxable
     * falls in 3000- bracket
     * 340 * .02 = 6.8 annual tax
     * round(6.8 / 52 weeks) = 0.13 tax
     */
    public function testVirginiaIncome_testCase11(): void
    {
        $results = $this->calculateTaxes(2, 0, 100.0);
        $this->assertThat(0.13, self::identicalTo($results->getTax(VirginiaIncome::class)));
    }

    /**
     * Test Case 12
     * Weekly Pay               $130.00
     * Exemptions               2
     * 65+/Blind Exemptions     2
     * Tax Due                  $0.12
     *
     * Math:
     * 100.00 wages * 52 weeks= 6760 gross
     * 2 personal exemptions * 930 = 1860
     * 2 other exemptions * 800 = 1600
     * 6760.00 - 3000 - 1860 - 0 = 300 taxable
     * falls in 3000- bracket
     * 300 * .02 = 6 annual tax
     * round(6 / 52 weeks) = 0.12 tax
     */
    public function testVirginiaIncome_testCase12(): void
    {
        $results = $this->calculateTaxes(2, 2, 130.0);
        $this->assertThat(0.11, self::identicalTo($results->getTax(VirginiaIncome::class)));
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

    private function calculateTaxes(int $exemptions, int $other_exemptions,
                                    float $earnings, bool $exempt = false): TaxResults
    {
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
