<?php

namespace Appleton\Taxes\Countries\US\Alabama\TuskegeeOccupational;

use Appleton\Taxes\Models\TaxArea;

class TuskegeeOccupationalTest extends \TestCase
{
    public function testTuskegeeOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.tuskegee'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.tuskegee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(TuskegeeOccupational::class));
    }
}
