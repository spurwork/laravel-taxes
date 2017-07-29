<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;

use Appleton\Taxes\Classes\BaseIncome;

abstract class AlabamaIncome extends BaseIncome
{
    const TYPE = 'state';
    const WITHHELD = true;

    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;
}
