<?php

namespace Appleton\Taxes\Countries\US\Alabama\MaconCountyOccupational;

class MaconCountyOccupationalTest extends \TestCase
{
    public function testMaconCountyOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.alabama.maconcounty'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
        });

        $this->assertSame(3.00, $results->getTax(MaconCountyOccupational::class));
    }
}
