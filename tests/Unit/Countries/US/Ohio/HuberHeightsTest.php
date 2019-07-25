<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\HuberHeights\HuberHeights;
use Carbon\Carbon;
use TestCase;

class HuberHeightsTest extends TestCase
{
    public function testHuberHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.huber_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.huber_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(HuberHeights::class));
    }
}
