<?php

namespace Appleton\Taxes\Countries\US\Maryland\AnneArundel\V20190101;

use Appleton\Taxes\Countries\US\Maryland\AnneArundel\AnneArundel as BaseAnneArundel;

class AnneArundel extends BaseAnneArundel
{
    public function getTaxRate()
    {
        return 0.0250;
    }
}