<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareEmployerTrainingTax;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class DelawareEmployerTrainingTax extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
