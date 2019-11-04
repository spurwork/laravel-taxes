<?php

namespace Appleton\Taxes\Countries\US\SouthDakota\SouthDakotaUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

class SouthDakotaUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
}
