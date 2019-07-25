<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\PortClinton\PortClinton;
use Carbon\Carbon;
use TestCase;

class PortClintonTest extends TestCase
{
    public function testPortClinton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.port_clinton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.port_clinton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(PortClinton::class));
    }
}
