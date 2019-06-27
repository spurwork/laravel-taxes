<?php
namespace Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class WashingtonDCUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
