<?php

namespace Appleton\Taxes\Classes;

class Taxes
{
    public function calculate(Closure $closure)
    {
        $closure($this);
    }
}
