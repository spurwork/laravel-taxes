<?php

namespace Appleton\Taxes\Classes;

use Closure;

class Taxes
{
    public function calculate(Closure $closure)
    {
        $closure($this);
    }
}
