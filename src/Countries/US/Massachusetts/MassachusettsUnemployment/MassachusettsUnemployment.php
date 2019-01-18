<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsUnemployment;

use Appleton\Taxes\Countries\US\FederalUnemployment\BaseStateUnemployment;

abstract class MassachusettsUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
