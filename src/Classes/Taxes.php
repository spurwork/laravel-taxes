<?php

namespace Appleton\Taxes\Classes;

use Closure;

class Taxes
{
    private function earnings()
    {
        echo 'earnings';
    }

    public function calculate(Closure $closure)
    {
        $closure($this);
    }
}
