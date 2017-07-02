<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class AlabamaIncome extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;

    public function __construct($date = null, $earnings, $pay_periods, $tax_information = null, $user = null)
    {
        parent::__construct($date, $earnings, $pay_periods, $tax_information, $user);
    }
}
