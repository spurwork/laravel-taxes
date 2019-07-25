<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\OlmstedFalls\OlmstedFalls;
use Carbon\Carbon;
use TestCase;

class OlmstedFallsTest extends TestCase
{
    public function testOlmstedFalls()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.olmsted_falls'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.olmsted_falls'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(OlmstedFalls::class));
    }
}
