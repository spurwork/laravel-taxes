<?php

namespace Appleton\Taxes\Countries\US\Alabama\SulligentOccupational;

class SulligentOccupationalTest extends \TestCase
{
    public function testSulligentOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.sulligent'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.sulligent'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(SulligentOccupational::class));
    }
}
