<?php

namespace Appleton\Taxes\Countries\US\Alabama\MossesOccupational;

class MossesOccupationalTest extends \TestCase
{
    public function testMossesOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.mosses'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.mosses'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(MossesOccupational::class));
    }
}
