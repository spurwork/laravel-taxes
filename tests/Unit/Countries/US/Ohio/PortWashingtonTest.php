<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\PortWashington\PortWashington;
use Carbon\Carbon;
use TestCase;

class PortWashingtonTest extends TestCase
{
    public function testPortWashington()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.port_washington'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.port_washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(PortWashington::class));
    }
}
