<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemploymentInsurance;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

abstract class NewJerseyUnemploymentInsurance extends BaseTax
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = true;
}
