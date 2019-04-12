<?php

namespace Appleton\Taxes\Countries\US\Maryland\PrinceGeorges\V20190101;

use Appleton\Taxes\Countries\US\Maryland\PrinceGeorges\PrinceGeorges as BasePrinceGeorges;

class PrinceGeorges extends BasePrinceGeorges
{
    public function getTaxRate()
    {
        return 0.032;
    }
}