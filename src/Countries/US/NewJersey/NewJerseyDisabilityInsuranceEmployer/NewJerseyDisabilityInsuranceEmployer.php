<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsuranceEmployer;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;
use Appleton\Taxes\Traits\HasWageBase;

abstract class NewJerseyDisabilityInsuranceEmployer extends BaseState
{
    use HasWageBase;

    const WITHHELD = false;
}
