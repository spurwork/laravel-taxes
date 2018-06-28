<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinUnemployment;

use Appleton\Taxes\Countries\US\FederalUnemployment\BaseStateUnemployment;

abstract class WisconsinUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
