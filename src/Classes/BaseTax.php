<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Traits\WithEarnings;

abstract class BaseTax
{
    use WithEarnings;

    const TYPE = 'base';
    const WITHHELD = false;
}
