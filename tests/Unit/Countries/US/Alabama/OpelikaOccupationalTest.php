<?php

namespace Appleton\Taxes\Countries\US\Alabama\OpelikaOccupational;

class OpelikaOccupationalTest extends \TestCase
{
    public function testOpelikaOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.opelika'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.opelika'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(34.5, $results->getTax(OpelikaOccupational::class));
    }
}
