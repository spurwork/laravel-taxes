<?php

namespace Appleton\Taxes\Countries\US\Indiana;

use Appleton\Taxes\Classes\BaseLocalIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;

abstract class IndianaLocalIncome extends BaseLocalIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.0323;

    private const PERSONAL_EXEMPTION_AMOUNTS = 1000;
    private const DEPENDENT_EXEMPTION_AMOUNT = 1500;

    protected $tax_information;

    public function __construct(IndianaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets(): array
    {
        return [[0, $this->getTaxRate(), 0]];
    }

    public function compute(Collection $tax_areas)
    {
        if (array_key_exists($this->tax_information->county_of_residence, self::COUNTIES)) {
            //
        } elseif (array_key_exists($this->tax_information->county_of_employment, self::COUNTIES)) {
            //
        }
    }

    public function getAdjustedEarnings()
    {
        $personal_allowances = self::PERSONAL_EXEMPTION_AMOUNTS * $this->tax_information->personal_exemptions;
        $dependent_allowances = self::DEPENDENT_EXEMPTION_AMOUNT * $this->tax_information->dependent_exemptions;

        $exemptions = ($personal_allowances + $dependent_allowances) / $this->payroll->pay_periods;
        return ($this->payroll->getEarnings() - $exemptions) * $this->payroll->pay_periods;
    }

    abstract public function getTaxRate(): float;
}
