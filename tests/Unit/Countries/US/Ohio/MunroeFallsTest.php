<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MunroeFalls\MunroeFalls;
use Carbon\Carbon;
use TestCase;

class MunroeFallsTest extends TestCase
{
    public function testMunroeFalls()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.munroe_falls'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.munroe_falls'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(MunroeFalls::class));
    }
}
