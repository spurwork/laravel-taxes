<?php

namespace Appleton\Taxes\Countries\US\Tennessee\TennesseeUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class TennesseeUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}
