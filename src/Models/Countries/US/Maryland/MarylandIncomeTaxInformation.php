<?php

namespace Appleton\Taxes\Models\Countries\US\Maryland;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;

class MarylandIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.maryland.maryland_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->dependents = 0;
        $tax_information->additional_withholding = 0;
        $tax_information->filing_status = MarylandIncome::FILING_SINGLE;
        $tax_information->exempt = false;
        $tax_information->local_exempt = false;
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
        return MarylandIncome::class;
    }
}
