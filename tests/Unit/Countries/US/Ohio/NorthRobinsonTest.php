<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthRobinson\NorthRobinson;
use Carbon\Carbon;
use TestCase;

class NorthRobinsonTest extends TestCase
{
    public function testNorthRobinson()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_robinson'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_robinson'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NorthRobinson::class));
    }
}
