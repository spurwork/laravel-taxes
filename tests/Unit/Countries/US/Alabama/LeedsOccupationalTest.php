<?php

namespace Appleton\Taxes\Countries\US\Alabama\LeedsOccupational;

class LeedsOccupationalTest extends \TestCase
{
    public function testLeedsOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.5482, -86.5444);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(LeedsOccupational::class));
    }
}
