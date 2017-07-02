<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Classes\BaseTax;

class RedBayOccupational extends BaseTax
{
    const TYPE = 'local';
    const WITHHELD = true;

    const TAX_RATE = 0.005;
}
