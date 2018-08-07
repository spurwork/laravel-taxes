<?php

namespace Appleton\Taxes\Countries\US\Alabama\BeavertonOccupational;

use Appleton\Taxes\Models\TaxArea;

class BeavertonOccupationalTest extends \TestCase
{
    public function testBeavertonOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.beaverton'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.beaverton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(BeavertonOccupational::class));
    }
}
