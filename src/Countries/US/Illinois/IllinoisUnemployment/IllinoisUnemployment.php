<?php

namespace Appleton\Taxes\Countries\US\Illinois\IllinoisUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

class IllinoisUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
    const STATE = 'IL';
}
