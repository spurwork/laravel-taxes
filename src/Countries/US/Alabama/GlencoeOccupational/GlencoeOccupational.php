<?php

namespace Appleton\Taxes\Countries\US\Alabama\GlencoeOccupational;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class GlencoeOccupational extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings)
    {
        parent::__construct($date, $earnings);
    }
}
