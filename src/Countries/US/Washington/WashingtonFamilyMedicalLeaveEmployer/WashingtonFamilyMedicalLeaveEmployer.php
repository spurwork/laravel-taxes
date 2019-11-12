<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeaveEmployer;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;
use Appleton\Taxes\Traits\HasWageBase;

abstract class WashingtonFamilyMedicalLeaveEmployer extends BaseState
{
    use HasWageBase;
    const WITHHELD = false;
}
