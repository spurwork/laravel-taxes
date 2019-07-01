<?php

namespace Appleton\Taxes\Models\Countries\US\California;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\California\CaliforniaIncome\CaliforniaIncome;

class CaliforniaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.california.california_income_tax_information';

    public static function getDefault(): CaliforniaIncomeTaxInformation
    {
        $tax_information = new self();
        $tax_information->filing_status = null;
        $tax_information->allowances = null;
        $tax_information->estimated_deductions = 0;
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
        return CaliforniaIncome::class;
    }
}
