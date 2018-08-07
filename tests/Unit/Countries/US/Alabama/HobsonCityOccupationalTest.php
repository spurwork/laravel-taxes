<?php

namespace Appleton\Taxes\Countries\US\Alabama\HobsonCityOccupational;

use Appleton\Taxes\Models\TaxArea;

class HobsonCityOccupationalTest extends \TestCase
{
    public function testHobsonCityOccupational()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.hobsoncity'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.hobsoncity'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(46.00, $results->getTax(HobsonCityOccupational::class));
    }
}
