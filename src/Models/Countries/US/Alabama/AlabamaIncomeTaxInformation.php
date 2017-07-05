<?php

namespace Appleton\Taxes\Models\Countries\US\Alabama;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Classes\Taxes;

class AlabamaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.alabama.alabama_income_tax_information';

    public static function getDefault($date)
    {
        $tax_information = app(static::class);
        $tax_information->dependents = 0;
        $tax_information->filing_status = Taxes::resolve(AlabamaIncome::class, $date)::FILING_SINGLE;
        return $tax_information;
    }
}
