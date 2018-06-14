<?php

namespace Appleton\Taxes\Countries\US\Alabama\AttallaOccupational;

class AttallaOccupationalTest extends \TestCase
{
    public function testAttallaOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.attalla'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.attalla'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(AttallaOccupational::class));
    }
}
