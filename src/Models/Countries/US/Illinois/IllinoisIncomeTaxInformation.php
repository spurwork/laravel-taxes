<?php

namespace Appleton\Taxes\Models\Countries\US\Illinois;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Illinois\IllinoisIncome\IllinoisIncome;

class IllinoisIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.illinois.illinois_income_tax_information';

    public static function getDefault(): IllinoisIncomeTaxInformation
    {
        $tax_information = new self();
        $tax_information->basic_allowances = 0;
        $tax_information->additional_allowances = 0;
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
        return IllinoisIncome::class;
    }
}
