<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Newcomerstown\Newcomerstown;
use Carbon\Carbon;
use TestCase;

class NewcomerstownTest extends TestCase
{
    public function testNewcomerstown()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.newcomerstown'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.newcomerstown'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Newcomerstown::class));
    }
}
