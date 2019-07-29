<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Lordstown\Lordstown;
use Carbon\Carbon;
use TestCase;

class LordstownTest extends TestCase
{
    public function testLordstown()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lordstown'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lordstown'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Lordstown::class));
    }
}
