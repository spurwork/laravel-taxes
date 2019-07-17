<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Rushsylvania\Rushsylvania;
use Carbon\Carbon;
use TestCase;

class RushsylvaniaTest extends TestCase
{
    public function testRushsylvania()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.rushsylvania'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.rushsylvania'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Rushsylvania::class));
    }
}
