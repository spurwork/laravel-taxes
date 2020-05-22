<?php

namespace Appleton\Taxes\Models\Countries\US\NorthDakota;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaIncome\NorthDakotaIncome;

class NorthDakotaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.north_dakota.north_dakota_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->filing_status = NorthDakotaIncome::FILING_SINGLE;
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
        return NorthDakotaIncome::class;
    }
}
