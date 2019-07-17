<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Stryker\Stryker;
use Carbon\Carbon;
use TestCase;

class StrykerTest extends TestCase
{
    public function testStryker()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.stryker'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.stryker'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Stryker::class));
    }
}
