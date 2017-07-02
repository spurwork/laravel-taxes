<?php

namespace Appleton\Taxes\Countries\US\Alabama\LynnOccupational;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class LynnOccupational extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings)
    {
        parent::__construct($date, $earnings);
    }
}
