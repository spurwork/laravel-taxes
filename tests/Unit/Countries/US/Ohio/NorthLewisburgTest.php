<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthLewisburg\NorthLewisburg;
use Carbon\Carbon;
use TestCase;

class NorthLewisburgTest extends TestCase
{
    public function testNorthLewisburg()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_lewisburg'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_lewisburg'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NorthLewisburg::class));
    }
}
