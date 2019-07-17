<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WestCarrollton\WestCarrollton;
use Carbon\Carbon;
use TestCase;

class WestCarrolltonTest extends TestCase
{
    public function testWestCarrollton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.west_carrollton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.west_carrollton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(WestCarrollton::class));
    }
}
