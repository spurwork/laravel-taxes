<?php

namespace Appleton\Taxes\Countries\US\Alabama\GoodwaterOccupational;

class GoodwaterOccupationalTest extends \TestCase
{
    public function testGoodwaterOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.0657, -86.0533);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(17.25, $results->getTax(GoodwaterOccupational::class));
    }
}
