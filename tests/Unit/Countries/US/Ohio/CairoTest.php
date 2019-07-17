<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Cairo\Cairo;
use Carbon\Carbon;
use TestCase;

class CairoTest extends TestCase
{
    public function testCairo()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.cairo'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.cairo'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.50, $results->getTax(Cairo::class));
    }
}
