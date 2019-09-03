<?php

namespace Appleton\Taxes\Models\Countries\US\Idaho;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Idaho\IdahoIncome\IdahoIncome;

class IdahoIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.idaho.idaho_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exemptions = 0;
        $tax_information->filing_status = 0;
        $tax_information->additional_withholding = 0;
        $tax_information->exempt = IdahoIncome::FILING_SINGLE;
        return $tax_information;
    }

    public static function getTax()
    {
        return IdahoIncome::class;
    }
}
