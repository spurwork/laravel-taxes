<?php

namespace Appleton\Taxes\Countries\US\Kentucky\JeffersonCounty;

use Appleton\Taxes\Classes\BaseLocalIncome;

abstract class JeffersonCounty extends BaseLocalIncome
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
