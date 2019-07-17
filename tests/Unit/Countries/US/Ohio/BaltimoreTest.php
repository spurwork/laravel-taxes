<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Baltimore\Baltimore;
use Carbon\Carbon;
use TestCase;

class BaltimoreTest extends TestCase
{
    public function testBaltimore()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.baltimore'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.baltimore'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Baltimore::class));
    }
}
