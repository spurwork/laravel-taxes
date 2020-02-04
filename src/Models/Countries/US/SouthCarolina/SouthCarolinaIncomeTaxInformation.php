<?php

namespace Appleton\Taxes\Models\Countries\US\SouthCarolina;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\SouthCarolinaIncome;

class SouthCarolinaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.south_carolina.south_carolina_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exemptions = 0;
        $tax_information->exempt = false;
        $tax_information->additional_withholding = 0;
        return $tax_information;
    }

    public static function getTax()
    {
        return SouthCarolinaIncome::class;
    }
}
