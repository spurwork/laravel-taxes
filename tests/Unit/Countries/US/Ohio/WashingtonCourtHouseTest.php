<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WashingtonCourtHouse\WashingtonCourtHouse;
use Carbon\Carbon;
use TestCase;

class WashingtonCourtHouseTest extends TestCase
{
    public function testWashingtonCourtHouse()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.washington_court_house'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.washington_court_house'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.85, $results->getTax(WashingtonCourtHouse::class));
    }
}
