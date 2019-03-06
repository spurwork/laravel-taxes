<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Models\TaxInformation;
use Appleton\Taxes\Traits\HasIncome;

abstract class BaseIncome extends BaseTax
{
    use HasIncome;

    const WITHHELD = true;

    abstract public function getTaxBrackets();
}
