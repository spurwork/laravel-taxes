<?php

namespace Appleton\Taxes\Models\Countries\US\Mississippi;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Mississippi\MississippiIncome\MississippiIncome;

class MississippiIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.mississippi.mississippi_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->additional_withholding = 0;
        $tax_information->exempt = false;
        $tax_information->filing_status = MississippiIncome::FILING_SINGLE;
        $tax_information->personal_exemptions = 0;

        return $tax_information;
    }

    public static function getTax()
    {
        return MississippiIncome::class;
    }
}
