<?php

namespace Appleton\Taxes\Countries\US\Alabama\RedBayOccupational;

class RedBayOccupationalTest extends \TestCase
{
    public function testRedBayOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(34.4398, -88.1409);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(11.5, $results->getTax(RedBayOccupational::class));
    }
}
