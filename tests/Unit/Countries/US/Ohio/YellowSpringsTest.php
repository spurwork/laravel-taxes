<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\YellowSprings\YellowSprings;
use Carbon\Carbon;
use TestCase;

class YellowSpringsTest extends TestCase
{
    public function testYellowSprings()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.yellow_springs'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.yellow_springs'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(YellowSprings::class));
    }
}
