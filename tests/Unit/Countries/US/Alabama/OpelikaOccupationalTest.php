<?php

namespace Appleton\Taxes\Countries\US\Alabama\OpelikaOccupational;

class OpelikaOccupationalTest extends \TestCase
{
    public function testOpelikaOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(32.6454, -85.3783);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(34.5, $results->getTax(OpelikaOccupational::class));
    }
}
