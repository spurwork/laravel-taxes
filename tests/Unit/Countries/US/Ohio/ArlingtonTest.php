<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Arlington\Arlington;
use Carbon\Carbon;
use TestCase;

class ArlingtonTest extends TestCase
{
    public function testArlington()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.arlington'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.arlington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Arlington::class));
    }
}
