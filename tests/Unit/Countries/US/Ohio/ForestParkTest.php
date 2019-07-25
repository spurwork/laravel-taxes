<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\ForestPark\ForestPark;
use Carbon\Carbon;
use TestCase;

class ForestParkTest extends TestCase
{
    public function testForestPark()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.forest_park'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.forest_park'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(ForestPark::class));
    }
}
