<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class MassachusettsUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
