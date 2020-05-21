<?php

namespace Appleton\Taxes\Models\Countries\US\Pennsylvania;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaIncome\PennsylvaniaIncome;
use Carbon\Carbon;

class PennsylvaniaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.pennsylvania.pennsylvania_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exempt = false;
        $tax_information->exempt_from_municipal_lst = false;
        $tax_information->exempt_from_school_district_lst = false;
        $tax_information->is_resident_psd_code_philadelphia = false;
        $tax_information->is_employer_psd_code_philadelphia = false;
        $tax_information->employer_eit_rate = 0;
        $tax_information->resident_eit_rate = 0;
        $tax_information->municipal_lst_total = 0;
        $tax_information->school_district_lst_total = 0;
        $tax_information->municipal_lst_lie_total = 0;
        $tax_information->school_district_lst_lie_total = 0;
        $tax_information->lst_paid_to_previous_employers = 0;
        $tax_information->wages_from_previous_employers = 0;
        $tax_information->exempt_from_lst_date = Carbon::now();
        return $tax_information;
    }

    public static function getTax()
    {
        return PennsylvaniaIncome::class;
    }
}
