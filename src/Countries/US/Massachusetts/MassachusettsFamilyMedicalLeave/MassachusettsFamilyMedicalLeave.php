<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeave;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class MassachusettsFamilyMedicalLeave extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
