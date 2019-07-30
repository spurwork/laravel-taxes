<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\TheVillageOfIndianHill\TheVillageOfIndianHill;
use Carbon\Carbon;
use TestCase;

class TheVillageOfIndianHillTest extends TestCase
{
    public function testTheVillageOfIndianHill()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.the_village_of_indian_hill'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.the_village_of_indian_hill'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.58, $results->getTax(TheVillageOfIndianHill::class));
    }
}
