<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\CoalGrove\CoalGrove;
use Carbon\Carbon;
use TestCase;

class CoalGroveTest extends TestCase
{
    public function testCoalGrove()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.coal_grove'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.coal_grove'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(CoalGrove::class));
    }
}
