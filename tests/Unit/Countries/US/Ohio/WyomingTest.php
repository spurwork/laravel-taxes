<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Wyoming\Wyoming;
use Carbon\Carbon;
use TestCase;

class WyomingTest extends TestCase
{
    public function testWyoming()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.wyoming'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.wyoming'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Wyoming::class));
    }
}
