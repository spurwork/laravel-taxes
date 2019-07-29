<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Ashville\Ashville;
use Carbon\Carbon;
use TestCase;

class AshvilleTest extends TestCase
{
    public function testAshville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.ashville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.ashville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Ashville::class));
    }
}
