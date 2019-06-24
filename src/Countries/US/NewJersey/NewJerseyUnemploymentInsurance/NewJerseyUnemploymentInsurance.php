<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemploymentInsurance;

use Appleton\Taxes\Classes\BaseTax;

abstract class NewJerseyUnemploymentInsurance extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;
}
