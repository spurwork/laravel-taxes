<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\CuyahogaFalls\CuyahogaFalls;
use Carbon\Carbon;
use TestCase;

class CuyahogaFallsTest extends TestCase
{
    public function testCuyahogaFalls()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.cuyahoga_falls'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.cuyahoga_falls'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(CuyahogaFalls::class));
    }
}
