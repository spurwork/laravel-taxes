<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Thurston\Thurston;
use Carbon\Carbon;
use TestCase;

class ThurstonTest extends TestCase
{
    public function testThurston()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.thurston'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.thurston'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Thurston::class));
    }
}
