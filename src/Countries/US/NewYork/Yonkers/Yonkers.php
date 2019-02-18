<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers;

abstract class Yonkers
{
    const TYPE = 'local';
    const PRIORITY = 9999;

    const FILING_SINGLE = 0;
    const FILING_MARRIED = 1;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    public $tax_total = 0;
}
