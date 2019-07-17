<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Conesville\Conesville;
use Carbon\Carbon;
use TestCase;

class ConesvilleTest extends TestCase
{
    public function testConesville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.conesville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.conesville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.50, $results->getTax(Conesville::class));
    }
}
