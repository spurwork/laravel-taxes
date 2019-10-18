<?php

namespace Appleton\Taxes\Models\Countries\US\Louisiana;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\LouisianaIncome;

class LouisianaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.louisiana.louisiana_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exemptions = 0;
        $tax_information->exempt = false;
        $tax_information->dependents = 0;
        $tax_information->filing_status = LouisianaIncome::FILING_SINGLE;

        return $tax_information;
    }

    public static function getTax()
    {
        return LouisianaIncome::class;
    }
}
