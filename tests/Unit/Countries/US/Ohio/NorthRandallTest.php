<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthRandall\NorthRandall;
use Carbon\Carbon;
use TestCase;

class NorthRandallTest extends TestCase
{
    public function testNorthRandall()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_randall'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_randall'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(8.25, $results->getTax(NorthRandall::class));
    }
}
