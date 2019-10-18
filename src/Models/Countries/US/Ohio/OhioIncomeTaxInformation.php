<?php

namespace Appleton\Taxes\Models\Countries\US\Ohio;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Ohio\OhioIncome\OhioIncome;

class OhioIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.ohio.ohio_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->dependents = 0;
        $tax_information->exempt = false;
        $tax_information->school_district_id = 0;
        return $tax_information;
    }

    public static function getTax()
    {
        return OhioIncome::class;
    }
}
