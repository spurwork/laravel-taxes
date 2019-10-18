<?php

namespace Appleton\Taxes\Models\Countries\US\Delaware;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Delaware\DelawareIncome\DelawareIncome;

class DelawareIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.delaware.delaware_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exemptions = 0;
        $tax_information->additional_withholding = 0;
        $tax_information->exempt = false;
        $tax_information->filing_status = DelawareIncome::FILING_SINGLE;
        return $tax_information;
    }

    public static function getTax()
    {
        return DelawareIncome::class;
    }
}
