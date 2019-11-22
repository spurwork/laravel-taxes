<?php

namespace Appleton\Taxes\Classes\WorkerTaxes\Taxes;

use Appleton\Taxes\Traits\HasIncome;

abstract class BaseStateIncome extends BaseState
{
    use HasIncome;

    const WITHHELD = true;

    abstract public function getTaxBrackets();
}
