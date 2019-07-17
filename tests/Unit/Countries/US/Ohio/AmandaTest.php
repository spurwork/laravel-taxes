<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Amanda\Amanda;
use Carbon\Carbon;
use TestCase;

class AmandaTest extends TestCase
{
    public function testAmanda()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.amanda'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.amanda'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Amanda::class));
    }
}
