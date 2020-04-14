<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome as BaseNewJerseyIncome;
use Appleton\Taxes\Models\Countries\US\NewJersey\NewJerseyIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

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

    const RATE_C_BRACKETS = [
        [0, 0.015, 0],
        [20000, 0.023, 300.00],
        [40000, 0.028, 760.00],
        [50000, 0.035, 1040.00],
        [60000, 0.056, 1390.00],
        [150000, 0.066, 6430.00],
        [500000, 0.099, 29530.00],
        [5000000, 0.118, 475030.00],
    ];

    const RATE_D_BRACKETS = [
        [0, 0.015, 0],
        [20000, 0.027, 300.00],
        [40000, 0.034, 840.00],
        [50000, 0.043, 1180.00],
        [60000, 0.056, 1610.00],
        [150000, 0.065, 6650.00],
        [500000, 0.099, 29400.00],
        [5000000, 0.118, 474900.00],
    ];

    const RATE_E_BRACKETS = [
        [0, 0.015, 0],
        [20000, 0.02, 300.00],
        [35000, 0.058, 600.00],
        [100000, 0.065, 4370.00],
        [500000, 0.099, 30370.00],
        [5000000, 0.118, 475870.00],
    ];



    const PERSONAL_EXEMPTION_ALLOWANCES = [
        self::FILING_SINGLE => 1000,
    ];

    public function __construct(NewJerseyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings() - $this->getDependentExemption(), $this->getTaxBrackets()) / $this->payroll->pay_periods) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(intval($this->tax_total * 100) / 100, 2);
    }

    public function getAdjustedEarnings(): int
    {
        $gross_wages = $this->payroll->getEarnings() * $this->payroll->pay_periods;
        return $gross_wages;
    }

    public function getDependentExemption()
    {
        return 1000 * $this->tax_information->exemptions;
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->tax_rate_table) {
            if ($this->tax_information->tax_rate_table === 'A') {
                return static::SINGLE_BRACKETS;
            } elseif ($this->tax_information->tax_rate_table === 'B') {
                return static::MARRIED_BRACKETS;
            } elseif ($this->tax_information->tax_rate_table === 'C') {
                return static::RATE_C_BRACKETS;
            } elseif ($this->tax_information->tax_rate_table === 'D') {
                return static::RATE_D_BRACKETS;
            } elseif ($this->tax_information->tax_rate_table === 'E') {
                return static::RATE_E_BRACKETS;
            } elseif ($this->tax_information->tax_rate_table === 'OTHER') {
                return $this->getNoTaxTableBracket();
            }
        } else {
            return $this->getNoTaxTableBracket();
        }
    }

    public function getNoTaxTableBracket()
    {
        if ($this->tax_information->filing_status === static::FILING_SINGLE
            || $this->tax_information->filing_status === static::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE) {
            return static::SINGLE_BRACKETS;
        }
        return static::MARRIED_BRACKETS;
    }
}
