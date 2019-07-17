<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Riverside\Riverside;
use Carbon\Carbon;
use TestCase;

class RiversideTest extends TestCase
{
    public function testRiverside()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.riverside'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.riverside'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Riverside::class));
    }
}
