<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class NewMexicoUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
}
