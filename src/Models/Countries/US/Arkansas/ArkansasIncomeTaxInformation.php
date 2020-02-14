<?php

namespace Appleton\Taxes\Models\Countries\US\Arkansas;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\ArkansasIncome;

class ArkansasIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.arkansas.arkansas_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exemptions = null;
        $tax_information->additional_withholding = 0;
        $tax_information->exempt = false;
        $tax_information->ar_tx_exempt = false;
        $tax_information->low_income = false;
        return $tax_information;
    }

    public function getAdditionalWithholding($value): int
    {
        return $value * 100;
    }

    public function setAdditionalWithholding($value): void
    {
        $this->attributes['additional_withholding'] = round($value / 100);
    }

    public static function getTax(): string
    {
        return ArkansasIncome::class;
    }
}
