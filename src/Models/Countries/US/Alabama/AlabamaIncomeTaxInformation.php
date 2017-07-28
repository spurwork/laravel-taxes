<?php

namespace Appleton\Taxes\Models\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Classes\Taxes;

class AlabamaIncomeTaxInformation extends BaseTaxInformationModel
{
    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;

    protected $config_name = 'taxes.tables.us.alabama.alabama_income_tax_information';

    public static function getDefault($date)
    {
        $tax_information = app(static::class);
        $tax_information->dependents = 0;
        $tax_information->filing_status = static::FILING_SINGLE;
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
}
