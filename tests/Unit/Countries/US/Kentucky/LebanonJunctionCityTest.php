<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\LebanonJunctionCity\LebanonJunctionCity;
use Carbon\Carbon;
use TestCase;

class LebanonJunctionCityTest extends TestCase
{
    public function testLebanonJunctionCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.lebanon_junction_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.lebanon_junction_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(LebanonJunctionCity::class));
    }
}
