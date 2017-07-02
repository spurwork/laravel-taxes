<?php

namespace Appleton\Taxes\Countries\US\Medicare;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class Medicare extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings, $ytd_earnings = 0)
    {
        parent::__construct($date, $earnings, $ytd_earnings);
    }
}
