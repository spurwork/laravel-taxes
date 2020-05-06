<?php

namespace Appleton\Taxes\Models\Countries\US\Pennsylvania;

use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;
use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaIncome\PennsylvaniaIncome;

class PennsylvaniaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.pennsylvania.pennsylvania_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exempt = false;
        $tax_information->resident_eit = null;
        $tax_information->non_resident_eit = null;

        return $tax_information;
    }

    public static function getTax()
    {
        return PennsylvaniaIncome::class;
    }
}
