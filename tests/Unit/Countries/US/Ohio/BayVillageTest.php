<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\BayVillage\BayVillage;
use Carbon\Carbon;
use TestCase;

class BayVillageTest extends TestCase
{
    public function testBayVillage()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.bay_village'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.bay_village'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(BayVillage::class));
    }
}
