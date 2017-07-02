<?php

namespace Appleton\Taxes\Countries\US\Alabama\RainbowCityOccupational;

use Appleton\Taxes\Classes\BaseTaxStrategy;

class RainbowCityOccupational extends BaseTaxStrategy
{
    const STRATEGIES = [
        '20170101',
    ];

    public function __construct($date = null, $earnings)
    {
        parent::__construct($date, $earnings);
    }
}
