<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaUnemployment;

use Appleton\Taxes\Countries\US\FederalUnemployment\BaseStateUnemployment;

abstract class NorthCarolinaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
