<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Sycamore\Sycamore;
use Carbon\Carbon;
use TestCase;

class SycamoreTest extends TestCase
{
    public function testSycamore()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.sycamore'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.sycamore'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Sycamore::class));
    }
}
