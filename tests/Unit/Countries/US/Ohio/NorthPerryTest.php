<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthPerry\NorthPerry;
use Carbon\Carbon;
use TestCase;

class NorthPerryTest extends TestCase
{
    public function testNorthPerry()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_perry'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_perry'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NorthPerry::class));
    }
}
