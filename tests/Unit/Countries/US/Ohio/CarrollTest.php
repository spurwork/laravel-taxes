<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Carroll\Carroll;
use Carbon\Carbon;
use TestCase;

class CarrollTest extends TestCase
{
    public function testCarroll()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.carroll'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.carroll'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(Carroll::class));
    }
}
