<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome as BaseNewJerseyIncome;
use Appleton\Taxes\Models\Countries\US\NewJersey\NewJerseyIncomeTaxInformation;

class NewJerseyIncome extends BaseNewJerseyIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0;
    const TAX_RATE = 0.05;

    const SINGLE_BRACKETS = [
        [0, 0.015, 0],
        [20000, 0.02, 300.00],
        [35000, 0.039, 600.00],
        [40000, 0.061, 795.00],
        [75000, 0.07, 2930.00],
        [500000, 0.099, 32680.00],
        [5000000, 0.118, 478180.00],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.015, 0],
        [20000, 0.02, 300.00],
        [50000, 0.027, 900.00],
        [70000, 0.039, 1440.00],
        [80000, 0.061, 1830.00],
        [150000, 0.07, 6100.00],
        [500000, 0.099, 30600.00],
        [5000000, 0.118, 476100.00],
    ];

    const PERSONAL_EXEMPTION_ALLOWANCES = [
        self::FILING_SINGLE => 1000,
    ];

    public function __construct(NewJerseyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function getDependentExemption()
    {
        return 1000 * $this->tax_information->exemptions;
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === static::FILING_SINGLE
            || $this->tax_information->filing_status === static::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE) {
            return static::SINGLE_BRACKETS;
        }
        return static::MARRIED_BRACKETS;
    }
}
