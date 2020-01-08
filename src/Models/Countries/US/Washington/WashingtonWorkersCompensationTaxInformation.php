<?php

namespace Appleton\Taxes\Models\Countries\US\Washington;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonWorkersCompensation\WashingtonWorkersCompensation;
use Carbon\Carbon;

class WashingtonWorkersCompensationTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.washington.washington_workers_compensation_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->class_code = '';
        $tax_information->subclass_code = '';
        $tax_information->employee_rate = 0;
        $tax_information->employer_rate = 0;
        $tax_information->effective_date = Carbon::now();

        return $tax_information;
    }

    public static function getTax()
    {
        return WashingtonWorkersCompensation::class;
    }
}
