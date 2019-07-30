<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthCanton\NorthCanton;
use Carbon\Carbon;
use TestCase;

class NorthCantonTest extends TestCase
{
    public function testNorthCanton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_canton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_canton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(NorthCanton::class));
    }
}
