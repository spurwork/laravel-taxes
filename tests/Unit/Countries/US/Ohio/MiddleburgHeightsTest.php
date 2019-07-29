<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MiddleburgHeights\MiddleburgHeights;
use Carbon\Carbon;
use TestCase;

class MiddleburgHeightsTest extends TestCase
{
    public function testMiddleburgHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.middleburg_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.middleburg_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(MiddleburgHeights::class));
    }
}
