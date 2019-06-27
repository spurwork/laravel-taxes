<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome as BaseColoradoIncome;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;

class ColoradoIncome extends BaseColoradoIncome
{
    private const SINGLE_BRACKETS = [
        [0, 0, 0],
        [2300, 0.0463, 0],
    ];

    private const MARRIED_BRACKETS = [
        [0, 0, 0],
        [8650, 0.0463, 0],
    ];

    private const EXEMPTION_AMOUNTS = [
        0 => 0,
        1 => 4050,
        2 => 8100,
        3 => 12150,
        4 => 16200,
        5 => 20250,
        6 => 24300,
        7 => 22950,
        8 => 21600,
        9 => 20250,
        10 => 18900,
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
