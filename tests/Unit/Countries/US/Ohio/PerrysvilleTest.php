<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Perrysville\Perrysville;
use Carbon\Carbon;
use TestCase;

class PerrysvilleTest extends TestCase
{
    public function testPerrysville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.perrysville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.perrysville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Perrysville::class));
    }
}
