<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\BostonHeights\BostonHeights;
use Carbon\Carbon;
use TestCase;

class BostonHeightsTest extends TestCase
{
    public function testBostonHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.boston_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.boston_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(BostonHeights::class));
    }
}
