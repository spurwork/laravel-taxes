<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyFamilyMedicalLeave;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class NewJerseyFamilyMedicalLeave extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
