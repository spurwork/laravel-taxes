<?php
namespace Appleton\Taxes\Countries\US\Arkansas\Texarkana\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Arkansas\Texarkana\Texarkana as BaseTexarkana;
use Illuminate\Database\Eloquent\Collection;

class Texarkana extends BaseTexarkana
{
    public function getTaxBrackets()
    {
        return 0.0;
    }

    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }
}
