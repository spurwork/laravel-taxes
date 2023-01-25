<?php

namespace Appleton\Taxes\Models\Countries\US;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;

class FederalIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.federal_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exemptions = 0;
        $tax_information->filing_status = FederalIncome::FILING_SINGLE;
        $tax_information->non_resident_alien = false;
        $tax_information->exempt = false;
        $tax_information->dependents_deduction_amount = 0;
        $tax_information->other_income = 0;
        $tax_information->deductions = 0;
        $tax_information->extra_withholding = 0;
        $tax_information->step_2_checked = false;
        $tax_information->form_version = '2020';
        return $tax_information;
    }

    public function getExemptions(): int
    {
        return $this->exemptions ?? 0;
    }

    public function getFilingStatus(): int
    {
        return $this->filing_status;
    }

    public function getDependentsDeductionAmount(): int
    {
        return $this->dependents_deduction_amount ?? 0;
    }

    public function getOtherIncome(): int
    {
        return $this->other_income ?? 0;
    }

    public function getDeductions(): int
    {
        return $this->deductions ?? 0;
    }

    public function getExtraWithholding(): int
    {
        return $this->is2020Version()
            ? $this->extra_withholding ?? 0
            : $this->additional_withholding ?? 0;
    }

    public function isStep2Checked(): bool
    {
        return $this->step_2_checked == true;
    }

    public function getAdditionalWithholding($value)
    {
        return $value * 100;
    }

    public function setAdditionalWithholding($value)
    {
        $this->attributes['additional_withholding'] = round($value / 100);
    }

    public static function getTax()
    {
        return FederalIncome::class;
    }

    public function isFilingMarriedJointly(): bool
    {
        return $this->filing_status === FederalIncome::FILING_JOINTLY;
    }

    public function is2020Version(): bool
    {
        return $this->form_version === FederalIncome::FORM_VERSION_2020;
    }
}
