<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthBaltimore\NorthBaltimore;
use Carbon\Carbon;
use TestCase;

class NorthBaltimoreTest extends TestCase
{
    public function testNorthBaltimore()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_baltimore'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_baltimore'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NorthBaltimore::class));
    }
}
