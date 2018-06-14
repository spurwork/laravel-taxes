<?php

namespace Appleton\Taxes\Countries\US\Alabama\BrilliantOccupational;

class BrilliantOccupationalTest extends \TestCase
{
    public function testBrilliantOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.brilliant'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.brilliant'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(BrilliantOccupational::class));
    }
}
