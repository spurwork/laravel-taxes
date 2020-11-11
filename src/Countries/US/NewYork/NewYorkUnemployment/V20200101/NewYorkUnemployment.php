<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkUnemployment\V20200101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkUnemployment\NewYorkUnemployment as BaseNewYorkUnemployment;

class NewYorkUnemployment extends BaseNewYorkUnemployment
{
    const FUTA_CREDIT = 0.054;
    const WAGE_BASE = 11600;
}
