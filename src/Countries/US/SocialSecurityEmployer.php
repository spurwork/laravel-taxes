<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;
use Appleton\Taxes\Traits\WithYtdEarnings;

class SocialSecurityEmployer extends SocialSecurity
{
    const TYPE = 'federal';
    const WITHHELD = false;
}
