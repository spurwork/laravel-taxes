<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WestMilton\WestMilton;
use Carbon\Carbon;
use TestCase;

class WestMiltonTest extends TestCase
{
    public function testWestMilton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.west_milton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.west_milton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(WestMilton::class));
    }
}
