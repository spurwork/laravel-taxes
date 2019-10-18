<?php


namespace Appleton\Taxes\Countries\US\Connecticut\ConnecticutUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class ConnecticutUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
