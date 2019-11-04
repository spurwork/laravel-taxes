<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemploymentInsurance;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;

abstract class NewJerseyUnemploymentInsurance extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
