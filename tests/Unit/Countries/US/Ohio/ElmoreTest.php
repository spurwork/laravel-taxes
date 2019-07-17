<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Elmore\Elmore;
use Carbon\Carbon;
use TestCase;

class ElmoreTest extends TestCase
{
    public function testElmore()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.elmore'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.elmore'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Elmore::class));
    }
}
