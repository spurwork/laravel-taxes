<?php

namespace Appleton\Taxes\Countries\US\Alabama\LynnOccupational;

class LynnOccupationalTest extends \TestCase
{
    public function testLynnOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(34.0470, -87.5497);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(LynnOccupational::class));
    }
}
