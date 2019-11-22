<?php

namespace Appleton\Taxes\Classes\PayrollLiabilities\Liabilities;

abstract class BasePayrollLiabilityState extends BasePayrollLiability
{
    public const TYPE = 'state';
    public const PRIORITY = 1;
}
