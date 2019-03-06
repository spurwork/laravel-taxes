<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class NewYorkUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
