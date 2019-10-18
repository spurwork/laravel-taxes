<?php

namespace Appleton\Taxes\Models\Countries\US\Maine;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Maine\MaineIncome\MaineIncome;

class MaineIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.maine.maine_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->allowances = 0;
        $tax_information->filing_status = 'S';
        $tax_information->exempt = false;
        return $tax_information;
    }

    public static function getTax()
    {
        return MaineIncome::class;
    }
}
