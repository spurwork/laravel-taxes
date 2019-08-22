<?php

namespace Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class SouthCarolinaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
