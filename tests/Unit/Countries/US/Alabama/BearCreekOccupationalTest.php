<?php

namespace Appleton\Taxes\Countries\US\Alabama\BearCreekOccupational;

class BearCreekOccupationalTest extends \TestCase
{
    public function testBearCreekOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.alabama.bearcreek'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(BearCreekOccupational::class));
    }
}
