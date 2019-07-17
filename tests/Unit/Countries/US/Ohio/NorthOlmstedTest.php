<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthOlmsted\NorthOlmsted;
use Carbon\Carbon;
use TestCase;

class NorthOlmstedTest extends TestCase
{
    public function testNorthOlmsted()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_olmsted'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_olmsted'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(NorthOlmsted::class));
    }
}
