<?php

namespace Appleton\Taxes\Countries\US\Maryland\Wicomico\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Wicomico\Wicomico as BaseWicomico;

class Wicomico extends BaseWicomico
{
    public function getTaxRate()
    {
        return 0.032;
    }
}