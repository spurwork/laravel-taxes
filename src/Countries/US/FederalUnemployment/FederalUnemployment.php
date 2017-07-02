<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class FederalUnemployment extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $credit = 0, $earnings, $ytd_earnings = 0)
    {
        parent::__construct($date, $credit, $earnings, $ytd_earnings);
    }
}
