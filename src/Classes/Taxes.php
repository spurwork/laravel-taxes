<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Models\TaxInformation;
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
