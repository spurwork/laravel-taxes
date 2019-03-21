<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class KentuckyUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}
