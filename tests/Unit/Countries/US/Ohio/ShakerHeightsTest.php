<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\ShakerHeights\ShakerHeights;
use Carbon\Carbon;
use TestCase;

class ShakerHeightsTest extends TestCase
{
    public function testShakerHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.shaker_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.shaker_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(ShakerHeights::class));
    }
}
