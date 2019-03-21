<?php

namespace Appleton\Taxes\Models\Countries\US\Kentucky;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome\KentuckyIncome;

class KentuckyIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.kentucky.kentucky_income_tax_information';

    public static function getDefault(): KentuckyIncomeTaxInformation
    {
        $tax_information = new self();
        $tax_information->additional_withholding = 0;
        $tax_information->exempt = false;
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
        return KentuckyIncome::class;
    }
}
