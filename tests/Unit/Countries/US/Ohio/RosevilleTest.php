<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Roseville\Roseville;
use Carbon\Carbon;
use TestCase;

class RosevilleTest extends TestCase
{
    public function testRoseville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.roseville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.roseville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Roseville::class));
    }
}
