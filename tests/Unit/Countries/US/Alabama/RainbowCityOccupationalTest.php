<?php

namespace Appleton\Taxes\Countries\US\Alabama\RainbowCityOccupational;

class RainbowCityOccupationalTest extends \TestCase
{
    public function testRainbowCityOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.9548, -86.0419);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(RainbowCityOccupational::class));
    }
}
