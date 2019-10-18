<?php

namespace Appleton\Taxes\Unit\Countries\US\WestVirginia;

use Appleton\Taxes\Classes\WorkerTaxes\TaxResults;
use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaIncome\WestVirginiaIncome;
use Appleton\Taxes\Models\Countries\US\WestVirginia\WestVirginiaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class WestVirginiaIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Single income, 3 allowances, 300 wages
     *
     * 300 * 52 = 15600 annual wages
     * 15600 - (3 * 2000) allowance credit = 9600 taxable income
     * 0 + (9600 * .03) tax withholding = 288 annual tax
     * 780 / 52 = 5.538 weekly tax
     */
    public function testCaliforniaIncomeTest1(): void
    {
        $results = $this->calculateTaxes(false, 3, 300);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(6.0));
    }

    /**
     * Single income, 2 allowances, 500 wages
     *
     * 500 * 52 = 26000 annual wages
     * 26000 - (2 * 2000) allowance credit = 22000 taxable income
     * 300 + ((22000 - 10000) * .04) tax withholding = 780 annual tax
     * 780 / 52 = 15 weekly tax
     */
    public function testCaliforniaIncomeTest2(): void
    {
        $results = $this->calculateTaxes(false, 2, 500.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(15.0));
    }

    /**
     * Single income, 4 allowances, 700 wages
     *
     * 700 * 52 = 36400 annual wages
     * 36400 - (4 * 2000) allowance credit = 28400 taxable income
     * 900 + ((28400 - 25000) * .045) tax withholding = 1053 annual tax
     * 1053 / 52 = 20.25 weekly tax
     */
    public function testCaliforniaIncomeTest3(): void
    {
        $results = $this->calculateTaxes(false, 4, 700.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(20.0));
    }

    /**
     * Single income, 1 allowance, 1000 wages
     *
     * 1000 * 52 = 52000 annual wages
     * 52000 - (1 * 2000) allowance credit = 50000 taxable income
     * 1575 + ((50000 - 40000) * .06) tax withholding = 2175 annual tax
     * 2175 / 52 = 41.826 weekly tax
     */
    public function testCaliforniaIncomeTest4(): void
    {
        $results = $this->calculateTaxes(false, 1, 1000.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(42.0));
    }

    /**
     * Single income, 2 allowances, 2000 wages
     *
     * 2000 * 52 = 104000 annual wages
     * 104000 - (2 * 2000) allowance credit = 100000 taxable income
     * 2775 + ((100000 - 60000) * .065) tax withholding = 5375 annual tax
     * 5375 / 52 = 103.365 weekly tax
     */
    public function testCaliforniaIncomeTest5(): void
    {
        $results = $this->calculateTaxes(false, 2, 2000.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(103.0));
    }

    /**
     * Two income, 4 allowances, 300 wages
     *
     * 300 * 52 = 15600 annual wages
     * 15600 - (4 * 2000) allowance credit = 7600 taxable income
     * 180 + ((7600 - 6000) * .04) tax withholding = 244 annual tax
     * 244 / 52 = 4.692 weekly tax
     */
    public function testCaliforniaIncomeTest6(): void
    {
        $results = $this->calculateTaxes(true, 4, 300.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(5.0));
    }

    /**
     * Two income, 1 allowance, 500 wages
     *
     * 500 * 52 = 26000 annual wages
     * 26000 - (1 * 2000) allowance credit = 24000 taxable income
     * 945 + ((24000 - 24000) * .06) tax withholding = 945 annual tax
     * 945 / 52 = 18.173 weekly tax
     */
    public function testCaliforniaIncomeTest7(): void
    {
        $results = $this->calculateTaxes(true, 1, 500.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(18.0));
    }

    /**
     * Two income, 2 allowances, 700 wages
     *
     * 700 * 52 = 36400 annual wages
     * 36400 - (2 * 2000) allowance credit = 32400 taxable income
     * 945 + ((32400 - 24000) * .06) tax withholding = 1449 annual tax
     * 1449 / 52 = 27.865 weekly tax
     */
    public function testCaliforniaIncomeTest8(): void
    {
        $results = $this->calculateTaxes(true, 2, 700.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(28.0));
    }

    /**
     * Two income, 4 allowances, 1000 wages
     *
     * 1000 * 52 = 52000 annual wages
     * 52000 - (4 * 2000) allowance credit = 44000 taxable income
     * 1665 + ((44000 - 36000) * .065) tax withholding = 2185 annual tax
     * 2185 / 52 = 42.019 weekly tax
     */
    public function testCaliforniaIncomeTest9(): void
    {
        $results = $this->calculateTaxes(true, 4, 1000.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(42.0));
    }

    /**
     * Two income, 3 allowances, 2000 wages
     *
     * 2000 * 52 = 104000 annual wages
     * 104000 - (3 * 2000) allowance credit = 98000 taxable income
     * 1665 + ((98000 - 36000) * .065) tax withholding = 5695 annual tax
     * 5695 / 52 = 109.519 weekly tax
     */
    public function testCaliforniaIncomeTest10(): void
    {
        $results = $this->calculateTaxes(true, 3, 2000.0);
        self::assertThat($results->getTax(WestVirginiaIncome::class), self::identicalTo(110.0));
    }

    private function calculateTaxes(bool $two_earner_percent, int $allowances,
                                    int $earnings): TaxResults
    {
        WestVirginiaIncomeTaxInformation::forUser($this->user)->update([
            'two_earner_percent' => $two_earner_percent,
            'allowances' => $allowances,
        ]);

        return $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.west_virginia'));
            $taxes->setWorkLocation($this->getLocation('us.west_virginia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });
    }
}
