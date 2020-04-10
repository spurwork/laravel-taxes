<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsWorkforceTrainingFundEmployer;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

abstract class MassachusettsWorkforceTrainingFundEmployer extends BaseTax
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = false;
}
