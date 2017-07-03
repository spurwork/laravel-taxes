<?php

namespace Appleton\Taxes\Countries\US\Alabama\BessemerOccupational;

class BessemerOccupationalTest extends \TestCase
{
    public function testBessemerOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.4018, -86.9544);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(BessemerOccupational::class));
    }
}
