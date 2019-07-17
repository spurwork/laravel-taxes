<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Waterville\Waterville;
use Carbon\Carbon;
use TestCase;

class WatervilleTest extends TestCase
{
    public function testWaterville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.waterville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.waterville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Waterville::class));
    }
}
