<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome as BaseColoradoIncome;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;

class ColoradoIncome extends BaseColoradoIncome
{
    private const SINGLE_BRACKETS = [
        [0, 0, 0],
        [3800, 0.0463, 0],
    ];

    private const MARRIED_BRACKETS = [
        [0, 0, 0],
        [11800, 0.0463, 0],
    ];

    private const EXEMPTION_AMOUNTS = [
        0 => 0,
        1 => 4200,
        2 => 8400,
        3 => 12600,
        4 => 16800,
        5 => 21000,
        6 => 25200,
        7 => 25200,
        8 => 25200,
        9 => 25200,
        10 => 25200,
    ];

    public function __construct(ColoradoIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    protected function getExemptionAmounts(): array
    {
        return self::EXEMPTION_AMOUNTS;
    }

    protected function getSingleBracket(): array
    {
        return self::SINGLE_BRACKETS;
    }

    protected function getMarriedBracket(): array
    {
        return self::MARRIED_BRACKETS;
    }
}
