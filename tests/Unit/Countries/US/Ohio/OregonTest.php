<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Oregon\Oregon;
use Carbon\Carbon;
use TestCase;

class OregonTest extends TestCase
{
    public function testOregon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.oregon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.oregon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(Oregon::class));
    }
}
