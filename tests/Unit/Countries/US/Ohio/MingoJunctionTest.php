<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MingoJunction\MingoJunction;
use Carbon\Carbon;
use TestCase;

class MingoJunctionTest extends TestCase
{
    public function testMingoJunction()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mingo_junction'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mingo_junction'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(MingoJunction::class));
    }
}
