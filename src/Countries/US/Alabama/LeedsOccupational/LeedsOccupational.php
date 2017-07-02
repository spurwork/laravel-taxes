<?php

namespace Appleton\Taxes\Countries\US\Alabama\LeedsOccupational;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class LeedsOccupational extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings)
    {
        parent::__construct($date, $earnings);
    }
}
