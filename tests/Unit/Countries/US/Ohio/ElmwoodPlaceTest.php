<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\ElmwoodPlace\ElmwoodPlace;
use Carbon\Carbon;
use TestCase;

class ElmwoodPlaceTest extends TestCase
{
    public function testElmwoodPlace()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.elmwood_place'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.elmwood_place'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(ElmwoodPlace::class));
    }
}
