<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Lyndhurst\Lyndhurst;
use Carbon\Carbon;
use TestCase;

class LyndhurstTest extends TestCase
{
    public function testLyndhurst()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lyndhurst'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lyndhurst'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Lyndhurst::class));
    }
}
