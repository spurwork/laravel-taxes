<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WayneLakes\WayneLakes;
use Carbon\Carbon;
use TestCase;

class WayneLakesTest extends TestCase
{
    public function testWayneLakes()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.wayne_lakes'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.wayne_lakes'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(WayneLakes::class));
    }
}
