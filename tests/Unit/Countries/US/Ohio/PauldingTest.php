<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Paulding\Paulding;
use Carbon\Carbon;
use TestCase;

class PauldingTest extends TestCase
{
    public function testPaulding()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.paulding'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.paulding'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Paulding::class));
    }
}
