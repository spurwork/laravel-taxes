<?php

namespace Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandDisabilityInsurance;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

abstract class RhodeIslandDisabilityInsurance extends BaseTax
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = true;
}
