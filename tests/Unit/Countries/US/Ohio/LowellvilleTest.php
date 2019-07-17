<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Lowellville\Lowellville;
use Carbon\Carbon;
use TestCase;

class LowellvilleTest extends TestCase
{
    public function testLowellville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lowellville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lowellville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Lowellville::class));
    }
}
