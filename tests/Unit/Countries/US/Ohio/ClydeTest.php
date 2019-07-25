<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Clyde\Clyde;
use Carbon\Carbon;
use TestCase;

class ClydeTest extends TestCase
{
    public function testClyde()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.clyde'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.clyde'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Clyde::class));
    }
}
