<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class CaliforniaUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}
