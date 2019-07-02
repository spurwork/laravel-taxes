<?php

namespace Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class WestVirginiaUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}
