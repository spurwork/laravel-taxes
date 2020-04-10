<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

abstract class SocialSecurityEmployer extends BaseTax
{
    use HasWageBase;

    public const TYPE = 'federal';
    public const WITHHELD = false;
    public const PRIORITY = 0;
}
