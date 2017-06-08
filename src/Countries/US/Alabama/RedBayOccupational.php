<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasTaxRate;

class RedBayOccupational extends BaseTax
{
    use HasTaxRate;

    const TAX_RATE = 0.005;
}
