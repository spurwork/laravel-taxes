<?php

namespace Appleton\Taxes\Models\Countries\US\Pennsylvania;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaIncome\PennsylvaniaIncome;
use Appleton\Taxes\Classes\BaseTaxInformationModel;

class PennsylvaniaIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.pennsylvania.pennsylvania_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exempt = false;
        return $tax_information;
    }

    public static function getTax()
    {
        return PennsylvaniaIncome::class;
    }
}
