<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class AlabamaUnemployment extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings = 0, $ytd_earnings = 0, $tax_rate = null)
    {
        parent::__construct($date, $earnings, $ytd_earnings, $tax_rate);
    }
}
