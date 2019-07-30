<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\ChagrinFalls\ChagrinFalls;
use Carbon\Carbon;
use TestCase;

class ChagrinFallsTest extends TestCase
{
    public function testChagrinFalls()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.chagrin_falls'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.chagrin_falls'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.55, $results->getTax(ChagrinFalls::class));
    }
}
