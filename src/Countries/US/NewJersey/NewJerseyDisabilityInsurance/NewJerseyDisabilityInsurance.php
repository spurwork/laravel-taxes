<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance;

use Appleton\Taxes\Classes\BaseState;
use Appleton\Taxes\Traits\HasWageBase;

abstract class NewJerseyDisabilityInsurance extends BaseState
{
    use HasWageBase;

    const WITHHELD = false;
}