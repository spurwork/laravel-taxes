<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MarionCity\MarionCity;
use Carbon\Carbon;
use TestCase;

class MarionCityTest extends TestCase
{
    public function testMarionCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.marion_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.marion_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(MarionCity::class));
    }
}
