<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthStar\NorthStar;
use Carbon\Carbon;
use TestCase;

class NorthStarTest extends TestCase
{
    public function testNorthStar()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_star'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_star'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.50, $results->getTax(NorthStar::class));
    }
}
