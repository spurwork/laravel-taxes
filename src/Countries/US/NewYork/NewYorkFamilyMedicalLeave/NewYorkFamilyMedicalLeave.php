<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;
use Appleton\Taxes\Traits\HasWageBase;

abstract class NewYorkFamilyMedicalLeave extends BaseState
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = true;
}
