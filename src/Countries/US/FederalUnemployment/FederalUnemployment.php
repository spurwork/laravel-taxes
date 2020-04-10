<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

abstract class FederalUnemployment extends BaseTax
{
    use HasWageBase;

    const TYPE = 'federal';
    const WITHHELD = false;
}
