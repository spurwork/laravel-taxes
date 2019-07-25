<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WilloughbyHills\WilloughbyHills;
use Carbon\Carbon;
use TestCase;

class WilloughbyHillsTest extends TestCase
{
    public function testWilloughbyHills()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.willoughby_hills'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.willoughby_hills'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(WilloughbyHills::class));
    }
}
