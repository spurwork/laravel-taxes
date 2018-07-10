<?php

namespace Appleton\Taxes\Models\Countries\US\Arizona;

use Appleton\Taxes\Countries\US\Arizona\ArizonaIncome\ArizonaIncome;
use Appleton\Taxes\Classes\BaseTaxInformationModel;

class ArizonaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.arizona.arizona_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->additional_withholding = 0;
        $tax_information->percentage_withheld = 2.7;
        $tax_information->exempt = false;
        return $tax_information;
    }

    public function getAdditionalWithholding($value)
    {
        return $value * 100;
    }

    public function setAdditionalWithholding($value)
    {
        $this->attributes['additional_withholding'] = round($value / 100);
    }

    public static function getTax()
    {
        return ArizonaIncome::class;
    }
}
