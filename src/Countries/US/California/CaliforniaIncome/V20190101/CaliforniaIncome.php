<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\California\CaliforniaIncome\CaliforniaIncome as BaseCaliforniaIncome;
use Appleton\Taxes\Models\Countries\US\California\CaliforniaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class CaliforniaIncome extends BaseCaliforniaIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.066;

    private const LOW_INCOME_EXEMPTIONS = [
        BaseCaliforniaIncome::FILING_SINGLE => 14573,
        BaseCaliforniaIncome::FILING_MARRIED => 14573,
        BaseCaliforniaIncome::FILING_MARRIED_TWO_OR_MORE_ALLOWANCES => 29146,
        BaseCaliforniaIncome::FILING_HEAD_OF_HOUSEHOLD => 29146,
    ];

    private const ESTIMATED_DEDUCTIONS = [
        0 => 0,
        1 => 1000,
        2 => 2000,
        3 => 3000,
        4 => 4000,
        5 => 5000,
        6 => 6000,
        7 => 7000,
        8 => 8000,
        9 => 9000,
        10 => 10000,
    ];

    private const STANDARD_DEDUCTIONS = [
        BaseCaliforniaIncome::FILING_SINGLE => 4401,
        BaseCaliforniaIncome::FILING_MARRIED => 4401,
        BaseCaliforniaIncome::FILING_MARRIED_TWO_OR_MORE_ALLOWANCES => 8802,
        BaseCaliforniaIncome::FILING_HEAD_OF_HOUSEHOLD => 8802,
    ];

    private const EXEMPTION_ALLOWANCES = [
        0 => 0,
        1 => 129.80,
        2 => 259.60,
        3 => 389.40,
        4 => 519.20,
        5 => 649.00,
        6 => 778.80,
        7 => 908.60,
        8 => 1038.40,
        9 => 1168.20,
        10 => 1298.00,
    ];

    private const SINGLE_BRACKETS = [
        [0, 0.011, 0],
        [8544, 0.022, 93.98],
        [20255, 0.044, 351.62],
        [31969, 0.066, 867.04],
        [44377, 0.088, 1685.97],
        [56085, 0.1023, 2716.27],
        [286492, 0.1133, 26286.91],
        [343788, 0.1243, 32778.55],
        [572980, 0.1353, 61267.12],
        [1000000, 0.1463, 119042.93],
    ];

    private const MARRIED_BRACKETS = [
        [0, 0.011, 0],
        [17088, 0.022, 187.97],
        [40510, 0.044, 703.25],
        [63938, 0.066, 1734.08],
        [88754, 0.088, 3371.94],
        [112170, 0.1023, 5432.55],
        [572984, 0.1133, 52573.82],
        [687576, 0.1243, 65557.09],
        [1000000, 0.1353, 104391.39],
        [1145961, 0.1463, 124139.90],
    ];

    private const HEAD_OF_HOUSEHOLD_BRACKETS = [
        [0, 0.011, 0],
        [17099, 0.022, 188.09],
        [40512, 0.044, 703.18],
        [52224, 0.066, 1218.51],
        [64632, 0.088, 2037.44],
        [76343, 0.1023, 3068.01],
        [389627, 0.1133, 35116.96],
        [467553, 0.1243, 43945.98],
        [779253, 0.1353, 82690.29],
        [1000000, 0.1463, 112557.36],
    ];

    public function __construct(CaliforniaIncomeTaxInformation $tax_information,
                                FederalIncomeTaxInformation $federal_income_tax_information,
                                Payroll $payroll)
    {
        parent::__construct($tax_information, $federal_income_tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    protected function getLowIncomeExemptions(): array
    {
        return self::LOW_INCOME_EXEMPTIONS;
    }

    protected function getStandardDeductions(): array
    {
        return self::STANDARD_DEDUCTIONS;
    }

    protected function getExemptionAllowances(): array
    {
        return self::EXEMPTION_ALLOWANCES;
    }

    protected function getEstimatedDeductions(): array
    {
        return self::ESTIMATED_DEDUCTIONS;
    }

    protected function getSingleTaxBrackets(): array
    {
        return self::SINGLE_BRACKETS;
    }

    protected function getMarriedTaxBrackets(): array
    {
        return self::MARRIED_BRACKETS;
    }

    protected function getHeadOfHouseholdTaxBrackets(): array
    {
        return self::HEAD_OF_HOUSEHOLD_BRACKETS;
    }
}
