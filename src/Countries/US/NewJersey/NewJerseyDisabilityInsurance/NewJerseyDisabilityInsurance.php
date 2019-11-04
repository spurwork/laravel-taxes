<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class NewJerseyDisabilityInsurance extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
