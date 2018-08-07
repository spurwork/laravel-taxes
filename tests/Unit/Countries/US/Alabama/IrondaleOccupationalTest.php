<?php

namespace Appleton\Taxes\Countries\US\Alabama\IrondaleOccupational;

use Appleton\Taxes\Models\TaxArea;

class IrondaleOccupationalTest extends \TestCase
{
    public function testIrondaleOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.irondale'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.irondale'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(IrondaleOccupational::class));
    }
}
