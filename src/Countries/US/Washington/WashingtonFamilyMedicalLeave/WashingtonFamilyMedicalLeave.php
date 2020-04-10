<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeave;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;
use Appleton\Taxes\Traits\HasWageBase;

abstract class WashingtonFamilyMedicalLeave extends BaseState
{
    use HasWageBase;

    const WITHHELD = true;
}
