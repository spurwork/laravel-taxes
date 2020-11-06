<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class KentuckyUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
    const STATE = 'KY';
}
