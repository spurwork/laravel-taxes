<?php

namespace Appleton\Taxes\Models\Countries\US\Minnesota;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome\MinnesotaIncome;

class MinnesotaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.minnesota.minnesota_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->additional_withholding = 0;
        $tax_information->allowances = 0;
        $tax_information->exempt = false;
        $tax_information->filing_status = MinnesotaIncome::FILING_SINGLE;
        return $tax_information;
    }

    public static function getTax()
    {
        return MinnesotaIncome::class;
    }
}
