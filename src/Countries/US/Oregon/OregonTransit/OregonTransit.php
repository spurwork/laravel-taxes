<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonTransit;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class OregonTransit extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
