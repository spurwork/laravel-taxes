<?php

namespace Appleton\Taxes\Models\Countries\US\Utah;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Utah\UtahIncome\UtahIncome;

class UtahIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.utah.utah_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->additional_withholding = 0;
        $tax_information->filing_status = UtahIncome::FILING_SINGLE;
        return $tax_information;
    }

    public static function getTax()
    {
        return UtahIncome::class;
    }
}
