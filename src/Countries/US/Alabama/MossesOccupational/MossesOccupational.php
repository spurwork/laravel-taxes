<?php

namespace Appleton\Taxes\Countries\US\Alabama\MossesOccupational;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class MossesOccupational extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings)
    {
        parent::__construct($date, $earnings);
    }
}
