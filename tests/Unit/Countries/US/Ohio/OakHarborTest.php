<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\OakHarbor\OakHarbor;
use Carbon\Carbon;
use TestCase;

class OakHarborTest extends TestCase
{
    public function testOakHarbor()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.oak_harbor'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.oak_harbor'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(OakHarbor::class));
    }
}
