<?php

namespace Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class BirminghamOccupational extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings)
    {
        parent::__construct($date, $earnings);
    }
}
