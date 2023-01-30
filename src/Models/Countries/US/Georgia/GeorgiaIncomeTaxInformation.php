<?php

namespace Appleton\Taxes\Models\Countries\US\Georgia;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;

class GeorgiaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.georgia.georgia_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->personal_allowances = 0;
        $tax_information->allowances = 0;
        $tax_information->dependents = 0;
        $tax_information->filing_status = GeorgiaIncome::FILING_SINGLE;
        $tax_information->exempt = false;
        return $tax_information;
    }

    public function getPersonalAllowance(): int
    {
        return $this->personal_allowances ?? 0;
    }

    public function hasPersonalAllowance(): bool
    {
        return $this->getPersonalAllowance() > 0;
    }

    public function hasSinglePersonalAllowance(): bool
    {
        return $this->getPersonalAllowance() === 1;
    }

    public function getAllowances(): int
    {
        return $this->allowances ?? 0;
    }

    public function getDependents(): int
    {
        return $this->dependents ?? 0;
    }

    public function getFilingStatus(): int
    {
        return $this->filing_status ?? GeorgiaIncome::FILING_SINGLE;
    }

    public function isFilingMarriedOneWorking(): bool
    {
        return $this->getFilingStatus() === GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING;
    }

    public function isFilingZero(): bool
    {
        return $this->getFilingStatus() === GeorgiaIncome::FILING_ZERO;
    }

    public function isExempt(): bool
    {
        return $this->exempt === true;
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
        return GeorgiaIncome::class;
    }
}
