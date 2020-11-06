<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class WisconsinUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const STATE = 'WI';
}
