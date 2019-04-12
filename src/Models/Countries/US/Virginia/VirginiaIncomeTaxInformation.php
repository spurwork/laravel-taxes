<?php

namespace Appleton\Taxes\Models\Countries\US\Virginia;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Virginia\VirginiaIncome\VirginiaIncome;

class VirginiaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.virginia.virginia_income_tax_information';

    public static function getDefault(): VirginiaIncomeTaxInformation
    {
        $tax_information = new self();
        $tax_information->exemptions = 0;
        $tax_information->sixty_five_plus_or_blind_exemptions = 0;
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
        return VirginiaIncome::class;
    }
}