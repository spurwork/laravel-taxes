<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\PioneerVillageCity\PioneerVillageCity;
use Carbon\Carbon;
use TestCase;

class PioneerVillageCityTest extends TestCase
{
    public function testPioneerVillageCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.pioneer_village_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.pioneer_village_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(PioneerVillageCity::class));
    }
}
