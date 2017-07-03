<?php

namespace Appleton\Taxes\Countries\US\Alabama\ShorterOccupational;

class ShorterOccupationalTest extends \TestCase
{
    public function testShorterOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.alabama.shorter'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(ShorterOccupational::class));
    }
}
