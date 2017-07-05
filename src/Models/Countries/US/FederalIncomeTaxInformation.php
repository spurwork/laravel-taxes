<?php

namespace Appleton\Taxes\Models\Countries\US;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Classes\Taxes;

class FederalIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.federal_income_tax_information';

    public static function getDefault($date)
    {
        $tax_information = app(static::class);
        $tax_information->exemptions = 0;
        $tax_information->filing_status = Taxes::resolve(FederalIncome::class, $date)::FILING_SINGLE;
        $tax_information->non_resident_alien = false;
        return $tax_information;
    }
}
