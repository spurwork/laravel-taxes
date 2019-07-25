<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\BroadviewHeights\BroadviewHeights;
use Carbon\Carbon;
use TestCase;

class BroadviewHeightsTest extends TestCase
{
    public function testBroadviewHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.broadview_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.broadview_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(BroadviewHeights::class));
    }
}
