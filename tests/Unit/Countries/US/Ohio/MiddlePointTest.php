<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MiddlePoint\MiddlePoint;
use Carbon\Carbon;
use TestCase;

class MiddlePointTest extends TestCase
{
    public function testMiddlePoint()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.middle_point'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.middle_point'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(MiddlePoint::class));
    }
}
