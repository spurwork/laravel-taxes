<?php

namespace Appleton\Taxes\Countries\US\Alabama\BessemerOccupational;

class BessemerOccupationalTest extends \TestCase
{
    public function testBessemerOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.bessemer'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.bessemer'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(BessemerOccupational::class));
    }
}
