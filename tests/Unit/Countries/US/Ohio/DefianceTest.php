<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Defiance\Defiance;
use Carbon\Carbon;
use TestCase;

class DefianceTest extends TestCase
{
    public function testDefiance()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.defiance'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.defiance'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.40, $results->getTax(Defiance::class));
    }
}
