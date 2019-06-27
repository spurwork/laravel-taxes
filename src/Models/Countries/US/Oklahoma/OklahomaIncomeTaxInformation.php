<?php

namespace Appleton\Taxes\Models\Countries\US\Oklahoma;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Oklahoma\OklahomaIncome\OklahomaIncome;

class OklahomaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.oklahoma.oklahoma_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exempt = false;
        $tax_information->dependents = 0;
        $tax_information->filing_status = OklahomaIncome::FILING_SINGLE;

        return $tax_information;
    }

    public static function getTax()
    {
        return OklahomaIncome::class;
    }
}
