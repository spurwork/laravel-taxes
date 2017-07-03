<?php

namespace Appleton\Taxes\Countries\US\Alabama\MidfieldOccupational;

class MidfieldOccupationalTest extends \TestCase
{
    public function testMidfieldOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.4615, -86.9089);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(MidfieldOccupational::class));
    }
}
