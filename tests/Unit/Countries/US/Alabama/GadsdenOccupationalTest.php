<?php

namespace Appleton\Taxes\Countries\US\Alabama\GadsdenOccupational;

class GadsdenOccupationalTest extends \TestCase
{
    public function testGadsdenOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.gadsden'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.gadsden'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(GadsdenOccupational::class));
    }
}
