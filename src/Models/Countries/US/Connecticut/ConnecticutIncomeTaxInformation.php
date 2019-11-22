<?php

namespace Appleton\Taxes\Models\Countries\US\Connecticut;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\ConnecticutIncome;

class ConnecticutIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.connecticut.connecticut_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->additional_withholding = 0;
        $tax_information->reduced_withholding = 0;
        $tax_information->exempt = false;
        $tax_information->filing_status = 'A';

        return $tax_information;
    }

    public static function getTax()
    {
        return ConnecticutIncome::class;
    }
}
