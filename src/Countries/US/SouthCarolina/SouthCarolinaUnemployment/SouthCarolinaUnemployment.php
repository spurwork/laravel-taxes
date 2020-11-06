<?php

namespace Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

class SouthCarolinaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const STATE = 'SC';
}
