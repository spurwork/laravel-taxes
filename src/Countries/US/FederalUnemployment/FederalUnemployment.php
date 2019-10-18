<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class FederalUnemployment extends BaseTax
{
    const TYPE = 'federal';
    const WITHHELD = false;
}
