<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Warren\Warren;
use Carbon\Carbon;
use TestCase;

class WarrenTest extends TestCase
{
    public function testWarren()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.warren'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.warren'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.50, $results->getTax(Warren::class));
    }
}
