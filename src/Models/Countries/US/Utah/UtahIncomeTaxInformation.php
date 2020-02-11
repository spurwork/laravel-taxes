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
        $tax_information->exempt = false;
        $tax_information->deductions = 0;
        $tax_information->dependents_deduction_amount = 0;
        $tax_information->other_income = 0;
        $tax_information->extra_withholding = 0;
        $tax_information->step_2_checked = false;

        return $tax_information;
    }

    public static function getTax()
    {
        return UtahIncome::class;
    }
}
