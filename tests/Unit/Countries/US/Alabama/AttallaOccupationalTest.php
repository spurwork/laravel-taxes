<?php

namespace Appleton\Taxes\Countries\US\Alabama\AttallaOccupational;

class AttallaOccupationalTest extends \TestCase
{
    public function testAttallaOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(34.0218, -86.0886);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(AttallaOccupational::class));
    }
}
