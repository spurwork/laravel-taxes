<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeave;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class WashingtonFamilyMedicalLeave extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
