<?php

namespace Appleton\Taxes\Classes;

abstract class BasePayrollState extends BasePayrollLiability
{
    public const TYPE = 'state';
    public const PRIORITY = 1;
}
