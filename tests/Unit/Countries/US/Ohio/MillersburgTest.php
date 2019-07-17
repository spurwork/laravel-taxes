<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Millersburg\Millersburg;
use Carbon\Carbon;
use TestCase;

class MillersburgTest extends TestCase
{
    public function testMillersburg()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.millersburg'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.millersburg'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Millersburg::class));
    }
}
