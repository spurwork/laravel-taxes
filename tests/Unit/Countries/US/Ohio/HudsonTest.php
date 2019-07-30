<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Hudson\Hudson;
use Carbon\Carbon;
use TestCase;

class HudsonTest extends TestCase
{
    public function testHudson()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.hudson'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.hudson'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Hudson::class));
    }
}
