<?php

namespace Appleton\Taxes\Countries\US\Alabama\FairfieldOccupational;

class FairfieldOccupationalTest extends \TestCase
{
    public function testFairfieldOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.alabama.fairfield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(FairfieldOccupational::class));
    }
}
