<?php

namespace Appleton\Taxes\Models\Countries\US\WestVirginia;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaIncome\WestVirginiaIncome;

class WestVirginiaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.west_virginia.west_virginia_income_tax_information';

    public static function getDefault(): WestVirginiaIncomeTaxInformation
    {
        $tax_information = new self();
        $tax_information->two_earner_percent = false;
        $tax_information->allowances = 0;
        $tax_information->additional_withholding = 0;
        $tax_information->exempt = false;
        return $tax_information;
    }

    public function getAdditionalWithholding(int $value): int
    {
        return $value * 100;
    }

    public function setAdditionalWithholding(int $value): void
    {
        $this->attributes['additional_withholding'] = round($value / 100);
    }

    public static function getTax(): string
    {
        return WestVirginiaIncome::class;
    }
}
