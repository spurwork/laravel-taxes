<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class SocialSecurityEmployer extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings)
    {
        parent::__construct($date, $earnings);
    }
}
