<?php

namespace Appleton\Taxes\Countries\US\Alabama\SouthsideOccupational;

class SouthsideOccupationalTest extends \TestCase
{
    public function testSouthsideOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.alabama.southside'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(SouthsideOccupational::class));
    }
}
