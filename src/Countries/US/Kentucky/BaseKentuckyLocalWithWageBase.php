<?php

namespace Appleton\Taxes\Countries\US\Kentucky;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseOccupational;
use Appleton\Taxes\Traits\HasWageBase;

abstract class BaseKentuckyLocalWithWageBase extends BaseOccupational
{
    use HasWageBase;
}
