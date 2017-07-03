<?php

namespace Appleton\Taxes\Countries\US\Alabama\GlencoeOccupational;

class GlencoeOccupationalTest extends \TestCase
{
    public function testGlencoeOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.9570, -85.932);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(GlencoeOccupational::class));
    }
}
