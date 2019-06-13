<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

class NewJerseyUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const WAGE_BASE = 1;
}
