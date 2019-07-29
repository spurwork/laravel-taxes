<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Gratis\Gratis;
use Carbon\Carbon;
use TestCase;

class GratisTest extends TestCase
{
    public function testGratis()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.gratis'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.gratis'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Gratis::class));
    }
}
