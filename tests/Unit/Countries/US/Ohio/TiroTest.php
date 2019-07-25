<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Tiro\Tiro;
use Carbon\Carbon;
use TestCase;

class TiroTest extends TestCase
{
    public function testTiro()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.tiro'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.tiro'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Tiro::class));
    }
}
