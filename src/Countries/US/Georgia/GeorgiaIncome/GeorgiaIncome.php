<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;

abstract class GeorgiaIncome extends BaseStateIncome
{
    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_MARRIED_JOINT_BOTH_WORKING = 2;
    const FILING_MARRIED_JOINT_ONE_WORKING = 3;
    const FILING_MARRIED_SEPARATE = 4;
    const FILING_HEAD_OF_HOUSEHOLD = 5;
}
