<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasTaxRate;

class AttallaOccupational extends BaseTax
{
    use HasTaxRate;

    const TYPE = 'local';
    const WITHHELD = true;

    const TAX_RATE = 0.02;
}
