<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaDisabilityInsurance;

use Appleton\Taxes\Classes\BaseTax;

abstract class CaliforniaDisabilityInsurance extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
