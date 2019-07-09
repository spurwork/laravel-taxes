<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\EarlingtonCity\EarlingtonCity;
use Carbon\Carbon;
use TestCase;

class EarlingtonCityTest extends TestCase
{
    public function testEarlingtonCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.earlington_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.earlington_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(EarlingtonCity::class));
    }
}
