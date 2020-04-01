<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareTrainingTaxEmployer;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;
use Appleton\Taxes\Traits\HasWageBase;

abstract class DelawareTrainingTaxEmployer extends BaseStateUnemployment
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = false;
}
