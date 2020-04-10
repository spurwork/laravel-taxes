<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyFamilyMedicalLeave;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

abstract class NewJerseyFamilyMedicalLeave extends BaseTax
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = true;
}
