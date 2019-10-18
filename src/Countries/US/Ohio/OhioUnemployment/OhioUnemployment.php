<?php


namespace Appleton\Taxes\Countries\US\Ohio\OhioUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class OhioUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
