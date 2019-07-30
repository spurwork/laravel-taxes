<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Genoa\Genoa;
use Carbon\Carbon;
use TestCase;

class GenoaTest extends TestCase
{
    public function testGenoa()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.genoa'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.genoa'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Genoa::class));
    }
}
