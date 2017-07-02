<?php

namespace Appleton\Taxes\Countries\US\Alabama\TuskegeeOccupational;

use Appleton\Taxes\Models\TaxArea;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TuskegeeOccupationalTest extends \TestCase
{
    use DatabaseTransactions;

    public function testTuskegeeOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setLocation(32.4302, -85.7077);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(46.00, $results->getTax(TuskegeeOccupational::class));
    }
}
