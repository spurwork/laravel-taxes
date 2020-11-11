<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

class WashingtonUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const STATE = 'WA';
}
