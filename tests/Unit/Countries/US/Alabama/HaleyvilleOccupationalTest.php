<?php

namespace Appleton\Taxes\Countries\US\Alabama\HaleyvilleOccupational;

class HaleyvilleOccupationalTest extends \TestCase
{
    public function testHaleyvilleOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.haleyville'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.haleyville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(HaleyvilleOccupational::class));
    }
}
