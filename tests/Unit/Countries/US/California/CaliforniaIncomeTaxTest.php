<?php

namespace Appleton\Taxes\Unit\Countries\US\California;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\California\CaliforniaIncome\CaliforniaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\California\CaliforniaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class CaliforniaIncomeTaxTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Single, 0 allowances, 0 estimated deductions, 280.25 wages
     *
     * 280.25 * 52 = 14573 annual wages
     * 14573 equal to 14573, no taxes
     */
    public function testCaliforniaIncomeTest1(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_SINGLE, 0, 0, 280.25);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(0.0));
    }


    /**
     * Single, 1 allowances, 0 estimated deductions, 300 wages
     *
     * 300 * 52 = 15600 annual wages
     * 15600 is not less than 14573, not exempt
     * 15600 - 0 estimated deductions = 15600
     * 15600 - 4401 standard deduction = 11199 taxable income
     * 93.98 + ((11199 - 8544) * .022) tax withholding = 152.39 tax liability
     * 152.39 - 129.80 tax credit = 22.59 tax amount
     * 22.59 / 52 = .434 weekly tax
     */
    public function testCaliforniaIncomeTest2(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_SINGLE, 1, 0, 300.0);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(0.43));
    }

    /**
     * Single, 2 allowances, 0 estimated deductions, 700 wages
     *
     * 700 * 52 = 36400 annual wages
     * 36400 is not less than 14573, not exempt
     * 36400 - 0 estimated deductions = 36400
     * 36400 - 4401 standard deduction = 31999 taxable income
     * 867.04 + ((31999 - 31969) * .066) tax withholding = 869.02 tax liability
     * 869.02 - 259.60 tax credit = 609.42 tax amount
     * 609.42 / 52 = 11.719 weekly tax
     */
    public function testCaliforniaIncomeTest4(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_SINGLE, 2, 0, 700.0);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(11.71));
    }

    /**
     * Married, 0 allowances, 0 estimated deductions, 280.25 wages
     *
     * 280.25 * 52 = 14573 annual wages
     * 14573 equal to 14573, no taxes
     */
    public function testCaliforniaIncomeTest5(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_MARRIED, 0, 0, 280.25);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(0.0));
    }

    /**
     * Married, 2 allowances, 0 estimated deductions, 560.50 wages
     *
     * 560.50 * 52 = 29146 annual wages
     * 29146 equal to 29146, no taxes
     */
    public function testCaliforniaIncomeTest6(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_MARRIED, 2, 0, 560.50);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(0.0));
    }

    /**
     * Married, 2 allowances, 0 estimated deductions, 600 wages
     *
     * 600 * 52 = 31200 annual wages
     * 31200 is not less than 29146, not exempt
     * 31200 - 0 estimated deductions = 31200
     * 31200 - 8802 standard deduction = 22398 taxable income
     * 187.97 + ((22398 - 17088) * .022) tax withholding = 304.79 tax liability
     * 304.79 - 259.60 tax credit = 45.19 tax amount
     * 45.19 / 52 = 0.869 weekly tax
     */
    public function testCaliforniaIncomeTest7(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_MARRIED, 2, 0, 600.0);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(0.86));
    }

    /**
     * Married, 2 allowances, 1 estimated deductions, 1000 wages
     *
     * 1000 * 52 = 52000 annual wages
     * 52000 is not less than 29146, not exempt
     * 52000 - 1000 estimated deductions = 51000
     * 51000 - 8802 standard deduction = 42198 taxable income
     * 703.25 + ((42198 - 40510) * .044) tax withholding = 777.522 tax liability
     * 777.522 - 259.60 tax credit = 517.922 tax amount
     * 517.922 / 52 = 9.96 weekly tax
     */
    public function testCaliforniaIncomeTest8(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_MARRIED, 2, 1, 1000.0);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(9.96));
    }

    /**
     *
     * Head of Household, 0 allowances, 0 estimated deductions, 560.50 wages
     *
     * 560.50 * 52 = 29146 annual wages
     * 29146 equals 29146, no tax
     */
    public function testCaliforniaIncomeTest9(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_HEAD_OF_HOUSEHOLD, 0, 0, 560.50);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(0.0));
    }

    /**
     * Head of Household, 3 allowances, 0 estimated deductions, 899 wages
     *
     * 899 * 52 = 52000 annual wages
     * 46748 is not less than 29146, not exempt
     * 46748 - 0 estimated deductions = 46748
     * 46748 - 8802 standard deduction = 37946 taxable income
     * 188.09 + ((37946 - 17099) * .022) tax withholding = 646.724 tax liability
     * 646.724 - 389.40 tax credit = 257.324 tax amount
     * 257.324 / 52 = 4.948 weekly tax
     */
    public function testCaliforniaIncomeTest10(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_HEAD_OF_HOUSEHOLD, 3, 0, 899.0);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(4.94));
    }

    /**
     * Single from federal tax information, 0 allowances, 0 estimated deductions, 1000 wages
     *
     * 1000 * 52 = 52000 annual wages
     * 52000 is not less than 14573, not exempt
     * 52000 - 0 estimated deductions = 46748
     * 52000 - 4401 standard deduction = 47599 taxable income
     * 1685.97 + ((47599 - 44377) * .088) tax withholding = 1969.506 tax liability
     * 1969.506 - 0 tax credit = 1969.506 tax amount
     * 1969.506 / 52 = 37.875 weekly tax
     */
    public function testCaliforniaIncomeUseFederalFilingStatus(): void
    {
        $results = $this->calculateTaxes(null, 0, 0, 1000);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(37.87));
    }

    /**
     * Single from no filing status, 0 allowances, 0 estimated deductions, 1000 wages
     *
     * 1000 * 52 = 52000 annual wages
     * 52000 is not less than 14573, not exempt
     * 52000 - 0 estimated deductions = 46748
     * 52000 - 4401 standard deduction = 47599 taxable income
     * 1685.97 + ((47599 - 44377) * .088) tax withholding = 1969.506 tax liability
     * 1969.506 - 0 tax credit = 1969.506 tax amount
     * 1969.506 / 52 = 37.875 weekly tax
     */
    public function testCaliforniaIncomeCantDetermineFilingStatus(): void
    {
        $results = $this->calculateTaxes(null, 0, 0, 1000, FederalIncome::FILING_SEPERATE);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(37.87));
    }

    /**
     * Single from no filing status, 0 allowances, 0 estimated deductions, 1000 wages
     *
     * 1000 * 52 = 52000 annual wages
     * 52000 is not less than 14573, not exempt
     * 52000 - 0 estimated deductions = 46748
     * 52000 - 4401 standard deduction = 47599 taxable income
     * 1685.97 + ((47599 - 44377) * .088) tax withholding = 1969.506 tax liability
     * 1969.506 - 129.80 tax credit = 1839.706 tax amount
     * 1969.506 / 52 = 35.378 weekly tax
     */
    public function testCaliforniaIncomeUseFederalExemptions(): void
    {
        $results = $this->calculateTaxes(CaliforniaIncome::FILING_SINGLE, null, 0, 1000,
            FederalIncome::FILING_SINGLE, 1);
        self::assertThat($results->getTax(CaliforniaIncome::class), self::identicalTo(35.37));
    }

    private function calculateTaxes(?string $filing_status, ?int $allowances, int $estimated_deductions,
                                    int $earnings, int $federal_filing_status = FederalIncome::FILING_SINGLE,
                                    int $federal_exemptions = 0): TaxResults
    {
        CaliforniaIncomeTaxInformation::forUser($this->user)->update([
            'allowances' => $allowances,
            'estimated_deductions' => $estimated_deductions,
            'filing_status' => $filing_status,
        ]);

        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $federal_exemptions,
            'filing_status' => $federal_filing_status,
        ]);

        return $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.california'));
            $taxes->setWorkLocation($this->getLocation('us.california'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });
    }
}
