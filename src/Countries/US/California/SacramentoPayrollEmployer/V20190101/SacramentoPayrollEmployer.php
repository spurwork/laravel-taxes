<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer\V20190101;

use Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer\SacramentoPayrollEmployer as BaseSacramentoPayrollEmployer;

class SacramentoPayrollEmployer extends BaseSacramentoPayrollEmployer
{
    private const INITIAL_TAX = 30.0000;
    private const START_AMOUNT = 1000000;
    private const MAX_LIABILITY = 500000;
    private const TAX_AMOUNT = .0004;

    public function getInitialTax(): float
    {
        return self::INITIAL_TAX;
    }

    public function getMaxLiability(): int
    {
        return self::MAX_LIABILITY;
    }

    public function getStartAmount(): int
    {
        return self::START_AMOUNT;
    }

    public function getTaxAmount(): float
    {
        return self::TAX_AMOUNT;
    }
}
