<?php

namespace Appleton\Taxes\Countries\US\Alabama\TarrantOccupational;

use Appleton\Taxes\Models\TaxArea;

class TarrantOccupationalTest extends \TestCase
{
    public function testTarrantOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.tarrant'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.tarrant'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(11.50, $results->getTax(TarrantOccupational::class));
    }
}
