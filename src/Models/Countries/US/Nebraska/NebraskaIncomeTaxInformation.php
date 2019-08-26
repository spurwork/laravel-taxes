<?php

namespace Appleton\Taxes\Models\Countries\US\Nebraska;

use Appleton\Taxes\Countries\US\Nebraska\NebraskaIncome\NebraskaIncome;
use Appleton\Taxes\Classes\BaseTaxInformationModel;

class NebraskaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.nebraska.nebraska_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->allowances = 0;
        $tax_information->filing_status = NebraskaIncome::FILING_SINGLE;
        $tax_information->exempt = false;
        $tax_information->lower_withholding_than_lb223 = false;
        return $tax_information;
    }

    public static function getTax()
    {
        return NebraskaIncome::class;
    }
}
