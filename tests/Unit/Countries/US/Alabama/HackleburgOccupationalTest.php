<?php

namespace Appleton\Taxes\Countries\US\Alabama\HackleburgOccupational;

class HackleburgOccupationalTest extends \TestCase
{
    public function testHackleburgOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(34.2773, -87.8286);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(HackleburgOccupational::class));
    }
}
