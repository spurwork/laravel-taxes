<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Mayfield\Mayfield;
use Carbon\Carbon;
use TestCase;

class MayfieldTest extends TestCase
{
    public function testMayfield()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mayfield'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mayfield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Mayfield::class));
    }
}
