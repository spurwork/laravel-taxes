<?php

namespace Appleton\Taxes\Countries\US\Alabama\BrilliantOccupational;

class BrilliantOccupationalTest extends \TestCase
{
    public function testBrilliantOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(34.0254, -87.7584);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(BrilliantOccupational::class));
    }
}
