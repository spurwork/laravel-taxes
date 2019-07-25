<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Crestline\Crestline;
use Carbon\Carbon;
use TestCase;

class CrestlineTest extends TestCase
{
    public function testCrestline()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.crestline'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.crestline'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Crestline::class));
    }
}
