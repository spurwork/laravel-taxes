<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkDisabilityInsurance;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;
use Appleton\Taxes\Traits\HasWageBase;

abstract class NewYorkDisabilityInsurance extends BaseState
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = true;
}
