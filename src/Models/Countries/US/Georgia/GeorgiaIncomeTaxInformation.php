<?php

namespace Appleton\Taxes\Models\Countries\US\Georgia;

use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Appleton\Taxes\Classes\BaseTaxInformationModel;

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
        return $tax_information;
    }

    public function getAdditionalWithholding($value)
    {
        return $value * 100;
    }

    public function setAdditionalWithholding($value)
    {
        $this->attributes['additional_withholding'] = round($value / 100);
    }
}
