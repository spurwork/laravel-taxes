<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkDisabilityInsurance;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;

abstract class NewYorkDisabilityInsurance extends BaseState
{
    const TYPE = 'state';
    const WITHHELD = true;
}
