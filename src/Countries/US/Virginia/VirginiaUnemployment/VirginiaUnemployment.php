<?php

namespace Appleton\Taxes\Countries\US\Virginia\VirginiaUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class VirginiaUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}