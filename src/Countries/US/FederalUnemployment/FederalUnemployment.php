<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment;

use Appleton\Taxes\Classes\BaseTax;

abstract class FederalUnemployment extends BaseTax
{
    const TYPE = 'federal';
    const WITHHELD = false;
}
