<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class ColoradoUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const STATE = 'CO';
}
