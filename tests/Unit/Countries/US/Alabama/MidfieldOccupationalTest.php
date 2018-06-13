<?php

namespace Appleton\Taxes\Countries\US\Alabama\MidfieldOccupational;

class MidfieldOccupationalTest extends \TestCase
{
    public function testMidfieldOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.midfield'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.midfield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(MidfieldOccupational::class));
    }
}
