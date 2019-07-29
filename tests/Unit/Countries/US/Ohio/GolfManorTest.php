<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\GolfManor\GolfManor;
use Carbon\Carbon;
use TestCase;

class GolfManorTest extends TestCase
{
    public function testGolfManor()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.golf_manor'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.golf_manor'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.10, $results->getTax(GolfManor::class));
    }
}
