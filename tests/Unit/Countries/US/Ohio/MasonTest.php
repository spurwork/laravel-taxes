<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Mason\Mason;
use Carbon\Carbon;
use TestCase;

class MasonTest extends TestCase
{
    public function testMason()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mason'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mason'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.36, $results->getTax(Mason::class));
    }
}
