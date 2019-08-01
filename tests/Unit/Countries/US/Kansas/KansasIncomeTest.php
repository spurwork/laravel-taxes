<?php

namespace Appleton\Taxes\Unit\Countries\US\Kansas;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Kansas\KansasIncome\KansasIncome;
use Appleton\Taxes\Models\Countries\US\Kansas\KansasIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class KansasIncomeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2019-01-01');
    }

    public function testKansasIncome_exempt(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE, 0, 0, true);
        $results = $this->calculateTaxes(1000);
        self::assertNull($results->getTax(KansasIncome::class));
    }

    /**
     * Single: $50 (Bracket 1)
     *
     * 2600 annual income
     * 0 tax
     */
    public function testKansasIncome_single_bracket_1(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE);
        $results = $this->calculateTaxes(50);
        self::assertNull($results->getTax(KansasIncome::class));
    }

    /**
     * Single: $300 (Bracket 2)
     *
     * 15600 annual income
     * ((15600 - 3000) * 0.031) + 0 = 390.6 annual tax
     * 390.6 / 52 = 7.51 weekly tax
     */
    public function testKansasIncome_single_bracket_2(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE);
        $results = $this->calculateTaxes(300);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(7.51));
    }

    /**
     * Single: $500 (Bracket 3)
     *
     * 26000 annual income
     * ((26000 - 18000) * 0.0525) + 465 = 885 annual tax
     * 885 / 52 = 17.01 weekly tax
     */
    public function testKansasIncome_single_bracket_3(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE);
        $results = $this->calculateTaxes(500);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(17.01));
    }

    /**
     * Single: $700 (Bracket 4)
     *
     * 36400 annual income
     * ((36400 - 33000) * 0.057) + 1252.5 = 1446.3 annual tax
     * 1446.3 / 52 = 27.81 weekly tax
     */
    public function testKansasIncome_single_bracket_4(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE);
        $results = $this->calculateTaxes(700);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(27.81));
    }

    /**
     * Married: $50 (Bracket 1)
     *
     * 2600 annual income
     * 0 tax
     */
    public function testKansasIncome_married_bracket_1(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_JOINT);
        $results = $this->calculateTaxes(50);
        self::assertNull($results->getTax(KansasIncome::class));
    }

    /**
     * Married: $300 (Bracket 2)
     *
     * 15600 annual income
     * ((15600 - 7500) * 0.031) + 0 = 251.1 annual tax
     * 251.1 / 52 = 4.82 weekly tax
     */
    public function testKansasIncome_married_bracket_2(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_JOINT);
        $results = $this->calculateTaxes(300);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(4.82));
    }

    /**
     * Married: $800 (Bracket 3)
     *
     * 41600 annual income
     * ((41600 - 37500) * 0.0525) + 930 = 1145.25 annual tax
     * 1145.25 / 52 = 22.02 weekly tax
     */
    public function testKansasIncome_married_bracket_3(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_JOINT);
        $results = $this->calculateTaxes(800);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(22.02));
    }

    /**
     * Married: $1,500 (Bracket 4)
     *
     * 78000 annual income
     * ((78000 - 67500) * 0.057) + 2505 = 3103.5 annual tax
     * 3103.5 / 52 = 59.68 weekly tax
     */
    public function testKansasIncome_married_bracket_4(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_JOINT);
        $results = $this->calculateTaxes(1500);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(59.68));
    }

    /**
     * Single: $500, 2 exemptions
     *
     * 26000 annual income
     * 26000 - (2 * 2250) allowance exemption = 21500 taxable income
     * ((21500 - 18000) * 0.0525) + 465 = 648.75 annual tax
     * 648.75 / 52 = 59.68 weekly tax
     */
    public function testKansasIncome_exemptions(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE, 2);
        $results = $this->calculateTaxes(500);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(12.47));
    }

    /**
     * Single: $500, $15 additional withholding
     *
     * 26000 annual income
     * ((26000 - 18000) * 0.0525) + 465 = 885 annual tax
     *  (885 / 52) + 15 = 32.01
     */
    public function testKansasIncome_additional_withholding(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE, 0, 15);
        $results = $this->calculateTaxes(500);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(32.01));
    }

    /**
     * Single: $500, Bi-weekly
     *
     * 13000 annual income
     * ((13000 - 3000) * 0.031) + 0 = 310 annual tax
     * 310 / 26 = 11.92 weekly tax
     */
    public function testKansasIncome_pay_periods(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE);
        $results = $this->calculateTaxes(500, 0, 'us.kansas', 26);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(11.92));
    }

    /**
     * Single: $300
     *
     * 15600 annual income
     * 15600 - (0 * 2250) allowance exemption = 15600 taxable income
     * ((15600 - 3000) * 0.031) + 0 = 390.6 annual tax
     * 390.6 / 52 = 7.52 weekly tax
     */
    public function testKansasIncome_test_1(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE);
        $results = $this->calculateTaxes(300);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(7.51));
    }

    /**
     * Single: $300, 2 allowances
     *
     * 15600 annual income
     * 15600 - (2 * 2250) allowance exemption = 11100 taxable income
     * ((11100 - 3000) * 0.031) + 0 = 251.1 annual tax
     * 251.1 / 52 = 4.82 weekly tax
     */
    public function testKansasIncome_test_2(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE, 2);
        $results = $this->calculateTaxes(300);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(4.82));
    }

    /**
     * Single: $500, 2 allowances
     *
     * 26000 annual income
     * 26000 - (2 * 2250) allowance exemption = 21500 taxable income
     * ((21500 - 18000) * 0.0525) + 465 = 648.75 annual tax
     * 648.75 / 52 = 12.47 weekly tax
     */
    public function testKansasIncome_test_3(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_SINGLE, 2);
        $results = $this->calculateTaxes(500);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(12.47));
    }

    /**
     * Married: $300
     *
     * 15600 annual income
     * 15600 - (0 * 2250) allowance exemption = 15600 taxable income
     * ((15600 - 7500) * 0.031) + 0 = 251.1 annual tax
     * 251.1 / 52 = 4.82 weekly tax
     */
    public function testKansasIncome_test_4(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_JOINT);
        $results = $this->calculateTaxes(300);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(4.82));
    }

    /**
     * Married: $300, 2 allowances
     *
     * 15600 annual income
     * 15600 - (2 * 2250) allowance exemption = 11100 taxable income
     * ((11100 - 7500) * 0.031) + 0 = 111.6 annual tax
     *  111.6 / 52 = 2.14 weekly tax
     */
    public function testKansasIncome_test_5(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_JOINT, 2);
        $results = $this->calculateTaxes(300);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(2.14));
    }

    /**
     * Married: $500, 2 allowances
     *
     * 26000 annual income
     * 26000 - (2 * 2250) allowance exemption = 21500 taxable income
     * ((21500 - 7500) * 0.031) + 0 = 434 annual tax
     *  434 / 52 = 8.34 weekly tax
     */
    public function testKansasIncome_test_6(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_JOINT, 2);
        $results = $this->calculateTaxes(500);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(8.34));
    }

    /**
     * Married: $1000, 2 allowances
     *
     * 52000 annual income
     * 52000 - (2 * 2250) allowance exemption = 47500 taxable income
     * ((47500 - 37500) * 0.0525) + 930 = 1455 annual tax
     *  1455 / 52 = 27.98 weekly tax
     */
    public function testKansasIncome_test_7(): void
    {
        $this->updateTaxInformation(KansasIncome::ALLOWANCE_RATE_JOINT, 2);
        $results = $this->calculateTaxes(1000);
        self::assertThat($results->getTax(KansasIncome::class), self::identicalTo(27.98));
    }

    private function updateTaxInformation(int $allowance_rate, int $total_allowances = 0,
                                          int $additional_withholding = 0, bool $exempt = false): void
    {
        KansasIncomeTaxInformation::forUser($this->user)->update([
            'allowance_rate' => $allowance_rate,
            'total_allowances' => $total_allowances,
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
        ]);
    }

    private function calculateTaxes(int $earnings, int $ytd_earnings = 0, string $work_location = 'us.kansas',
                                    int $pay_periods = 52): TaxResults
    {

        return $this->taxes->calculate(function ($taxes) use ($earnings, $ytd_earnings, $work_location, $pay_periods) {
            $taxes->setHomeLocation($this->getLocation('us.kansas'));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setYtdEarnings($ytd_earnings);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods($pay_periods);
        });
    }
}
