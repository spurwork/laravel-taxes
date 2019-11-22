<?php

namespace Appleton\Taxes\Classes\PayrollLiabilities\Liabilities;

use Appleton\Taxes\Classes\PayrollLiabilities\CompanyPayroll;
use Illuminate\Support\Collection;

abstract class BasePayrollLiability
{
    public const SCOPE = 'payroll';
    public const WITHHELD = true;
    public const PRIORITY = 9999;

    protected $company_payroll;

    public function __construct(CompanyPayroll $company_payroll)
    {
        $this->company_payroll = $company_payroll;
    }

    abstract public function compute(Collection $tax_areas): int;

    abstract public function getWages(Collection $tax_areas): int;
}
