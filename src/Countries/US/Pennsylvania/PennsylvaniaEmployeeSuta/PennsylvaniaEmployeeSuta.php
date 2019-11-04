<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaEmployeeSuta;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class PennsylvaniaEmployeeSuta extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = true;
}
