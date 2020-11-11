<?php

namespace Appleton\Taxes\Countries\US\Texas\TexasUnemployment\V20180101;

use Appleton\Taxes\Countries\US\Texas\TexasUnemployment\TexasUnemployment as BaseTexasUnemployment;

class TexasUnemployment extends BaseTexasUnemployment
{
    const FUTA_CREDIT = 0.054;
    const WAGE_BASE = 9000;
}
