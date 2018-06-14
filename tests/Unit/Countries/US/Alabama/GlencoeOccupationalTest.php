<?php

namespace Appleton\Taxes\Countries\US\Alabama\GlencoeOccupational;

class GlencoeOccupationalTest extends \TestCase
{
    public function testGlencoeOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.glencoe'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.glencoe'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(GlencoeOccupational::class));
    }
}
