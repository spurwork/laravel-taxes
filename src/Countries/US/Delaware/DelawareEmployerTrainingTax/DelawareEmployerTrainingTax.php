<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareEmployerTrainingTax;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class DelawareEmployerTrainingTax extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
