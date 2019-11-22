<?php

namespace Appleton\Taxes\Countries\US\Vermont\VermontIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Vermont\VermontIncomeTaxInformation;

abstract class VermontIncome extends BaseStateIncome
{
    public const FILING_SINGLE = 'FILING_SINGLE';
    public const FILING_MARRIED_FILING_JOINTLY = 'FILING_MARRIED_FILING_JOINTLY';
    public const FILING_MARRIED_FILING_SEPARATELY = 'FILING_MARRIED_FILING_SEPARATELY';
    public const FILING_MARRIED_FILING_SINGLE = 'FILING_MARRIED_FILING_SINGLE';

    public const FILING_STATUSES = [
        self::FILING_SINGLE => self::FILING_SINGLE,
        self::FILING_MARRIED_FILING_JOINTLY => self::FILING_MARRIED_FILING_JOINTLY,
        self::FILING_MARRIED_FILING_SEPARATELY => self::FILING_MARRIED_FILING_SEPARATELY,
        self::FILING_MARRIED_FILING_SINGLE => self::FILING_MARRIED_FILING_SINGLE,
    ];

    protected $tax_information;
    protected $federal_income;

    abstract protected function getSupplementalIncomeTaxRate(): float;

    abstract protected function getAdditionalWithholdingRate(): float;

    abstract protected function getAllowanceAmount(): float;

    abstract protected function getMarriedBrackets(): array;

    abstract protected function getSingleBrackets(): array;

    public function __construct(VermontIncomeTaxInformation $tax_information,
                                FederalIncome $federal_income,
                                Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
        $this->federal_income = $federal_income;
    }

    public function getSupplementalIncomeTax()
    {
        $supplemental_rate = $this->federal_income::SUPPLEMENTAL_TAX_RATE
            * $this->getSupplementalIncomeTaxRate();
        return $this->payroll->getSupplementalEarnings() * $supplemental_rate;
    }

    public function getAdjustedEarnings()
    {
        $allowances = $this->tax_information->allowances * $this->getAllowanceAmount();
        $earnings = $this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings();

        return ($earnings * $this->payroll->pay_periods) - $allowances;
    }

    public function getTaxBrackets()
    {
        $is_filing_married = $this->tax_information->filing_status === static::FILING_MARRIED_FILING_JOINTLY
            || $this->tax_information->filing_status === static::FILING_MARRIED_FILING_SEPARATELY;

        return $is_filing_married ? $this->getMarriedBrackets() : $this->getSingleBrackets();
    }

    public function getAdditionalWithholding()
    {
        $additional_withholding_rate = $this->federal_income->tax_information->additional_withholding
            * $this->getAdditionalWithholdingRate();
        $additional_withholding = $this->tax_information->additional_withholding
            + $additional_withholding_rate;

        return max(min($this->payroll->getNetEarnings(), $additional_withholding), 0);
    }
}
