<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WestLiberty\WestLiberty;
use Carbon\Carbon;
use TestCase;

class WestLibertyTest extends TestCase
{
    public function testWestLiberty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.west_liberty'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.west_liberty'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(WestLiberty::class));
    }
}
