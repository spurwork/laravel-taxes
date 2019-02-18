<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers;

use Appleton\Taxes\Classes\BaseTax;

abstract class Yonkers extends BaseTax
{
    const TYPE = 'local';

    const FILING_SINGLE = 0;
    const FILING_MARRIED = 1;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];
}
