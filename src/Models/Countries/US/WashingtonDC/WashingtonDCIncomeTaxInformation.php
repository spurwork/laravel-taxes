<?php

namespace Appleton\Taxes\Models\Countries\US\WashingtonDC;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\WashingtonDCIncome;

class WashingtonDCIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.washingtondc.washingtondc_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exempt = false;
        $tax_information->filing_status = WashingtonDCIncome::FILING_SINGLE;
        $tax_information->dependents = 0;
        $tax_information->additional_withholding = 0;

        return $tax_information;
    }

    public static function getTax()
    {
        return WashingtonDCIncome::class;
    }
}
