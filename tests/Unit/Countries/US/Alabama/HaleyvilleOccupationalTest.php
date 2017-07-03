<?php

namespace Appleton\Taxes\Countries\US\Alabama\HaleyvilleOccupational;

class HaleyvilleOccupationalTest extends \TestCase
{
    public function testHaleyvilleOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(34.2265, -87.6214);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(HaleyvilleOccupational::class));
    }
}
