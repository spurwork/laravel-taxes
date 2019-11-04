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

    public static function getTax()
    {
        return FederalIncome::class;
    }
}
