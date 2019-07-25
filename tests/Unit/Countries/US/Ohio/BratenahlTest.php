<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Bratenahl\Bratenahl;
use Carbon\Carbon;
use TestCase;

class BratenahlTest extends TestCase
{
    public function testBratenahl()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.bratenahl'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.bratenahl'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Bratenahl::class));
    }
}
