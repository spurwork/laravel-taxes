<?php

namespace Appleton\Taxes\Countries\US\Texas\TexasUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;

abstract class TexasUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
