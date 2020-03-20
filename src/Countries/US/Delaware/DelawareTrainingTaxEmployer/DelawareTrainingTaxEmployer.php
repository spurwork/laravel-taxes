<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareTrainingTaxEmployer;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class DelawareTrainingTaxEmployer extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
