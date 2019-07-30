<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WestUnity\WestUnity;
use Carbon\Carbon;
use TestCase;

class WestUnityTest extends TestCase
{
    public function testWestUnity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.west_unity'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.west_unity'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(WestUnity::class));
    }
}
