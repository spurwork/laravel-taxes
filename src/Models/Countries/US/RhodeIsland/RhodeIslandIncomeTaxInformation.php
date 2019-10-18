<?php

namespace Appleton\Taxes\Models\Countries\US\RhodeIsland;

use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandIncome\RhodeIslandIncome;
use Appleton\Taxes\Classes\WorkerTaxes\BaseTaxInformationModel;

class RhodeIslandIncomeTaxInformation extends BaseTaxInformationModel
{
    protected $config_name = 'taxes.tables.us.rhode_island.rhode_island_income_tax_information';

    public static function getDefault()
    {
        $tax_information = new self();
        $tax_information->exemptions = 0;
        $tax_information->additional_withholding = 0;
        $tax_information->exempt = false;
        return $tax_information;
    }

    public static function getTax()
    {
        return RhodeIslandIncome::class;
    }
}
