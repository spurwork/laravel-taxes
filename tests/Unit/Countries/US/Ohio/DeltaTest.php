<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Delta\Delta;
use Carbon\Carbon;
use TestCase;

class DeltaTest extends TestCase
{
    public function testDelta()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.delta'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.delta'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Delta::class));
    }
}
