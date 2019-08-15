<?php

namespace Appleton\Taxes\Countries\US\Ohio\Akron\V20190101;

use Appleton\Taxes\Countries\US\Ohio\Akron\Akron as BaseAkron;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Akron extends BaseAkron
{
    public const TAX_RATE = 0.025;

    public function compute(Collection $tax_areas)
    {
        if ($this->payroll->birth_date->diffInYears(Carbon::now()->endOfYear()) >= 18) {
            $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);
            return round($this->tax_total, 2);
        }

        return 0.0;
    }
}
