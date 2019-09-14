<?php

namespace Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class RhodeIslandUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
