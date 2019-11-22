<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class SocialSecurity extends BaseTax
{
    const TYPE = 'federal';
    const WITHHELD = true;
    const PRIORITY = 0;
}
