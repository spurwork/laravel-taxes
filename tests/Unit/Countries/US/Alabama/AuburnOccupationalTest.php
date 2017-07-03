<?php

namespace Appleton\Taxes\Countries\US\Alabama\AuburnOccupational;

class AuburnOccupationalTest extends \TestCase
{
    public function testAuburnOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(32.6099, -85.4808);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(AuburnOccupational::class));
    }
}
