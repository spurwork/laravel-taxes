<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Perry\Perry;
use Carbon\Carbon;
use TestCase;

class PerryTest extends TestCase
{
    public function testPerry()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.perry'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.perry'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Perry::class));
    }
}
