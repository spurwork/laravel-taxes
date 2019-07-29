<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Navarre\Navarre;
use Carbon\Carbon;
use TestCase;

class NavarreTest extends TestCase
{
    public function testNavarre()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.navarre'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.navarre'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Navarre::class));
    }
}
