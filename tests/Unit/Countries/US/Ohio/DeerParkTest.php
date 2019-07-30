<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\DeerPark\DeerPark;
use Carbon\Carbon;
use TestCase;

class DeerParkTest extends TestCase
{
    public function testDeerPark()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.deer_park'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.deer_park'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(DeerPark::class));
    }
}
