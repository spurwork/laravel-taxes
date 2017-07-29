<?php

namespace Appleton\Taxes\Countries\US\Medicare;

use Appleton\Taxes\Classes\BaseTax;

abstract class Medicare extends BaseTax
{
    const TYPE = 'federal';
    const WITHHELD = true;
}
