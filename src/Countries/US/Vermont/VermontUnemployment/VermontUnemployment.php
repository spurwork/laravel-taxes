<?php

namespace Appleton\Taxes\Countries\US\Vermont\VermontUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class VermontUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}
