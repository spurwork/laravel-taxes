<?php

namespace Appleton\Taxes\Unit\Countries\US\Illinois;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Illinois\IllinoisIncome\IllinoisIncome;
use Appleton\Taxes\Models\Countries\US\Illinois\IllinoisIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class IllinoisIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Test Case 1
     * Weekly Pay               $300.00
     * Basic Allowances         0
     * Additional Allowances    0
     * Tax Due                  $14.85
     *
     * Math:
     * 0 basic allowances * 2275 = 0
     * 0 additional allowances * 1000 = 0
     * 0 total allowances / 52 weeks = 0
     * 300 - 0 = 300 taxable wages
     * round(.0495 * 300) = 14.85 tax
     */
    public function testVirginiaIncome_testCase1(): void
    {
        $results = $this->calculateTaxes(0, 0, 300.0);
        $this->assertThat(14.85, self::identicalTo($results->getTax(IllinoisIncome::class)));
    }

    /**
     * Test Case 2
     * Weekly Pay               $700.00
     * Basic Allowances         2
     * Additional Allowances    1
     * Tax Due                  $29.37
     *
     * Math:
     * 2 basic allowances * 2275 = 4550
     * 1 additional allowances * 1000 = 1000
     * 4550 + 1000 total allowances / 52 weeks = 106.7307
     * 700 - 106.7307 = 593.2692 taxable wages
     * round(.0495 * 593.2692) = 29.37 tax
     */
    public function testVirginiaIncome_testCase2(): void
    {
        $results = $this->calculateTaxes(2, 1, 700.0);
        $this->assertThat(29.36, self::identicalTo($results->getTax(IllinoisIncome::class)));
    }

    /**
     * Test Case 3
     * Weekly Pay               $700.00
     * Basic Allowances         0
     * Additional Allowances    1
     * Tax Due                  $33.70
     *
     * Math:
     * 0 basic allowances * 2275 = 0
     * 1 additional allowances * 1000 = 1000
     * 0 + 1000 total allowances / 52 weeks = 19.2308
     * 700 - 19.2308 = 680.7692 taxable wages
     * round(.0495 * 680.7692) = 33.70 tax
     */
    public function testVirginiaIncome_testCase3(): void
    {
        $results = $this->calculateTaxes(0, 1, 700.0);
        $this->assertThat(33.69, self::identicalTo($results->getTax(IllinoisIncome::class)));
    }

    /**
     * Exempt
     * Weekly Pay               $300.00
     * Tax Due                  $0.00
     */
    public function testVirginiaIncome_exempt(): void
    {
        $results = $this->calculateTaxes(0, 0, 300.0, true);
        $this->assertThat(0.0, self::identicalTo($results->getTax(IllinoisIncome::class)));
    }

    /**
     * Additional Withholding
     * Weekly Pay               $300.00
     * Basic Allowances         0
     * Additional Allowances    0
     * Additional Withholding   $10.00
     * Tax Due                  $24.85
     *
     * Math:
     * 0 basic allowances * 2275 = 0
     * 0 additional allowances * 1000 = 0
     * 0 total allowances / 52 weeks = 0
     * 300 - 0 = 300 taxable wages
     * round(.0495 * 300) = 14.85
     * 14.85 + 10.00 additional withholding = 24.85 tax
     */
    public function testVirginiaIncome_additionalWithholding(): void
    {
        $results = $this->calculateTaxes(0, 0, 300.0, false, 10.0);
        $this->assertThat(24.85, self::identicalTo($results->getTax(IllinoisIncome::class)));
    }

    private function calculateTaxes(int $basic_allowances, int $additional_allowances,
                                    float $earnings, bool $exempt = false,
                                    int $additional_withholding = 0): TaxResults
    {
        IllinoisIncomeTaxInformation::createForUser([
            'basic_allowances' => $basic_allowances,
            'additional_allowances' => $additional_allowances,
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
        ], $this->user);

        return $this->taxes->calculate(function (Taxes $taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.illinois'));
            $taxes->setWorkLocation($this->getLocation('us.illinois'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });
    }
}
