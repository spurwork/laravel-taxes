<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Ada\Ada;
use Carbon\Carbon;
use TestCase;

class AdaTest extends TestCase
{
    public function testAda()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.ada'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.ada'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.95, $results->getTax(Ada::class));
    }
}
