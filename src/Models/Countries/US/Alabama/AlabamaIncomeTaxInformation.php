<?php

namespace Appleton\Taxes\Models\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;

class AlabamaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.alabama.alabama_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->dependents = 0;
        $tax_information->filing_status = AlabamaIncome::FILING_SINGLE;
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
        return AlabamaIncome::class;
    }
}
