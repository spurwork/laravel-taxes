<?php

namespace Appleton\Taxes\Countries\US\Maryland\QueenAnnes\V20190101;

use Appleton\Taxes\Countries\US\Maryland\QueenAnnes\QueenAnnes as BaseQueenAnnes;

class QueenAnnes extends BaseQueenAnnes
{
    public function getTaxRate()
    {
        return 0.032;
    }
}