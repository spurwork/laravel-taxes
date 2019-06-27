<?php
namespace Appleton\Taxes\Countries\US\Mississippi\MississippiUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Mississippi\MississippiUnemployment\MississippiUnemployment as BaseMississippiUnemployment;

class MississippiUnemployment extends BaseMississippiUnemployment
{
    const FUTA_CREDIT = 0.06;
    const NEW_EMPLOYER_RATE = 0.012;
    const WAGE_BASE = 1400;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.mississippi.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
