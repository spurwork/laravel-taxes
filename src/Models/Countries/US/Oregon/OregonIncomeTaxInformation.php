<?php

namespace Appleton\Taxes\Models\Countries\US\Oregon;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Oregon\OregonIncome\OregonIncome;

class OregonIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.oregon.oregon_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exempt = false;
        $tax_information->exemptions = 0;
        $tax_information->additional_withholding = 0;
        $tax_information->filing_status = OregonIncome::FILING_SINGLE;

        return $tax_information;
    }

    public static function getTax()
    {
        return OregonIncome::class;
    }
}
