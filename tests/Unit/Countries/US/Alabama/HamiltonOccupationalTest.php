<?php

namespace Appleton\Taxes\Countries\US\Alabama\HamiltonOccupational;

class HamiltonOccupationalTest extends \TestCase
{
    public function testHamiltonOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(34.1423, -87.9886);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(HamiltonOccupational::class));
    }
}
