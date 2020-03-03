<?php

namespace Appleton\Taxes\Models\Countries\US\NewMexico;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome;

class NewMexicoIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.new_mexico.new_mexico_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->additional_withholding = 0;
        $tax_information->exemptions = 0;
        $tax_information->filing_status = NewMexicoIncome::FILING_SINGLE;
        $tax_information->exempt = false;
        $tax_information->additional_withholding = 0;
        $tax_information->dependents_deduction_amount = 0;
        $tax_information->other_income = 0;
        $tax_information->deductions = 0;
        $tax_information->extra_withholding = 0;
        $tax_information->step_2_checked = false;
        $tax_information->form_version = '2020';

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
        return NewMexicoIncome::class;
    }
}
