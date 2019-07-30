<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Portsmouth\Portsmouth;
use Carbon\Carbon;
use TestCase;

class PortsmouthTest extends TestCase
{
    public function testPortsmouth()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.portsmouth'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.portsmouth'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.50, $results->getTax(Portsmouth::class));
    }
}
