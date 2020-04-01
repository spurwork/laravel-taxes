<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaDisabilityInsurance;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

abstract class CaliforniaDisabilityInsurance extends BaseTax
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = true;
}
