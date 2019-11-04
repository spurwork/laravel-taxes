<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;

abstract class NewYorkFamilyMedicalLeave extends BaseState
{
    const TYPE = 'state';
    const WITHHELD = true;
}
