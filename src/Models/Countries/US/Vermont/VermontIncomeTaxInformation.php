<?php

namespace Appleton\Taxes\Models\Countries\US\Vermont;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Vermont\VermontIncome\VermontIncome;

class VermontIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.vermont.vermont_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->filing_status = VermontIncome::FILING_SINGLE;
        $tax_information->allowances = 0;
        $tax_information->additional_withholding = 0;
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
        return VermontIncome::class;
    }
}
