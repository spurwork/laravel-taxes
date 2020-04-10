<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

abstract class NewJerseyDisabilityInsurance extends BaseTax
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = true;
}
