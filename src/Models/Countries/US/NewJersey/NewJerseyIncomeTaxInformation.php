<?php

namespace Appleton\Taxes\Models\Countries\US\NewJersey;

use Appleton\Taxes\Classes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome;

class NewJerseyIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.new_jersey.new_jersey_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exemptions = 0;
        $tax_information->additional_withholding = 0;
        $tax_information->filing_status = NewJerseyIncome::FILING_SINGLE;

        return $tax_information;
    }

    public static function getTax()
    {
        return NewJerseyIncome::class;
    }
}
