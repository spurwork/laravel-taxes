<?php

namespace Appleton\Taxes\Countries\US\Alabama\FortDepositOccupational;

use Appleton\Taxes\Models\TaxArea;

class FortDepositOccupationalTest extends \TestCase
{
    public function testFortDepositOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.fortdeposit'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.fortdeposit'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(FortDepositOccupational::class));
    }
}
