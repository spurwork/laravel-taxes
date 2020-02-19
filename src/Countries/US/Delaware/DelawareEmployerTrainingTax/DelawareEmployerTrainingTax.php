<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareEmployerTrainingTax;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;

abstract class DelawareEmployerTrainingTax extends BaseState
{
    const TYPE = 'state';
    const WITHHELD = true;
}
