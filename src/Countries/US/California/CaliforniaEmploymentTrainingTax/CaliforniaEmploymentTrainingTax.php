<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaEmploymentTrainingTax;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;
use Appleton\Taxes\Traits\HasWageBase;

abstract class CaliforniaEmploymentTrainingTax extends BaseState
{
    use HasWageBase;

    const WITHHELD = false;
}
