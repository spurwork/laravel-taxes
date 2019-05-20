<?php

namespace Appleton\Taxes\Countries\US\Medicare;

use Appleton\Taxes\Classes\BaseTax;

abstract class Medicare extends BaseTax
{
    const TYPE = 'federal';
    const WITHHELD = true;

    const FILING_SINGLE = 0;
    const FILING_WIDOW = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPARATE = 4;

    const PRIORITY = 0;
}
