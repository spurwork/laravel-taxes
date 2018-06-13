<?php

namespace Appleton\Taxes\Countries\US\Alabama\HackleburgOccupational;

class HackleburgOccupationalTest extends \TestCase
{
    public function testHackleburgOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.hackleburg'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.hackleburg'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(HackleburgOccupational::class));
    }
}
