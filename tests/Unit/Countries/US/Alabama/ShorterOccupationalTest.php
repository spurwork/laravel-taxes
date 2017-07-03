<?php

namespace Appleton\Taxes\Countries\US\Alabama\ShorterOccupational;

class ShorterOccupationalTest extends \TestCase
{
    public function testShorterOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(32.3951, -85.9184);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(ShorterOccupational::class));
    }
}
