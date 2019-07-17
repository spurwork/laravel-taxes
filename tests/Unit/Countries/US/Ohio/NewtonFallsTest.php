<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewtonFalls\NewtonFalls;
use Carbon\Carbon;
use TestCase;

class NewtonFallsTest extends TestCase
{
    public function testNewtonFalls()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.newton_falls'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.newton_falls'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NewtonFalls::class));
    }
}
