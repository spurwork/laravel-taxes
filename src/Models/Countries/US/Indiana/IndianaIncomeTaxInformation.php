<?php

namespace Appleton\Taxes\Models\Countries\US\Indiana;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome;

class IndianaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.indiana.indiana_income_tax_information';

    public static function getDefault(): IndianaIncomeTaxInformation
    {
        $tax_information = new self();
        $tax_information->personal_exemptions = 0;
        $tax_information->dependent_exemptions = 0;
        $tax_information->additional_withholding = 0;
        $tax_information->additional_county_withholding = 0;
        $tax_information->county_lived = null;
        $tax_information->county_worked = null;
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

    public function getAdditionalCountyWithholding(int $value): int
    {
        return $value * 100;
    }

    public function setAdditionalCountyWithholding(int $value): void
    {
        $this->attributes['additional_county_withholding'] = round($value / 100);
    }

    public static function getTax(): string
    {
        return IndianaIncome::class;
    }
}