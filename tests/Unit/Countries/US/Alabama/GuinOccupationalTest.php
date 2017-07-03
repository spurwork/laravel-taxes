<?php

namespace Appleton\Taxes\Countries\US\Alabama\GuinOccupational;

class GuinOccupationalTest extends \TestCase
{
    public function testGuinOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.alabama.guin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(GuinOccupational::class));
    }
}
