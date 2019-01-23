<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkUnemployment;

use Appleton\Taxes\Countries\US\FederalUnemployment\BaseStateUnemployment;

abstract class NewYorkUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
