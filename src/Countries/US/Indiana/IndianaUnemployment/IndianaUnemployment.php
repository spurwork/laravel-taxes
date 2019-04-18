<?php

namespace Appleton\Taxes\Countries\US\Indiana\IndianaUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class IndianaUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}
