<?php

namespace Appleton\Taxes\Countries\US\Kansas\KansasUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class KansasUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}
