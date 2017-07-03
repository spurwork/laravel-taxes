<?php

namespace Appleton\Taxes\Countries\US\Alabama\GuinOccupational;

class GuinOccupationalTest extends \TestCase
{
    public function testGuinOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.9657, -87.9147);
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(GuinOccupational::class));
    }
}
