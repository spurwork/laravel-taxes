<?php

namespace Appleton\Taxes\Models\Countries\US\Kansas;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Kansas\KansasIncome\KansasIncome;

class KansasIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.kansas.kansas_income_tax_information';

    public static function getDefault(): KansasIncomeTaxInformation
    {
        $tax_information = new self();
        $tax_information->allowance_rate = KansasIncome::ALLOWANCE_RATE_SINGLE;
        $tax_information->total_allowances = 0;
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
        return KansasIncome::class;
    }
}
