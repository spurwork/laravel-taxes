<?php

namespace Appleton\Taxes\Countries\US\Maine\MaineUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class MaineUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
