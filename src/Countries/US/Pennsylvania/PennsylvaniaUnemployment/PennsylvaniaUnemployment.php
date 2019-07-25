<?php
namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class PennsylvaniaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
