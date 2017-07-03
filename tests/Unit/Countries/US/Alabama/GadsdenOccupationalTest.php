<?php

namespace Appleton\Taxes\Countries\US\Alabama\GadsdenOccupational;

class GadsdenOccupationalTest extends \TestCase
{
    public function testGadsdenOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(34.0143, -86.0066);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(GadsdenOccupational::class));
    }
}
