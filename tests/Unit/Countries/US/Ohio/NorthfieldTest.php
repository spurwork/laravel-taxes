<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Northfield\Northfield;
use Carbon\Carbon;
use TestCase;

class NorthfieldTest extends TestCase
{
    public function testNorthfield()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.northfield'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.northfield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Northfield::class));
    }
}
