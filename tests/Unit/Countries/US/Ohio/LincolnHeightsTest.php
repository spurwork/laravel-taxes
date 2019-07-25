<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\LincolnHeights\LincolnHeights;
use Carbon\Carbon;
use TestCase;

class LincolnHeightsTest extends TestCase
{
    public function testLincolnHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lincoln_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lincoln_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(LincolnHeights::class));
    }
}
