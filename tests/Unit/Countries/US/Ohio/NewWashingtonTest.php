<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewWashington\NewWashington;
use Carbon\Carbon;
use TestCase;

class NewWashingtonTest extends TestCase
{
    public function testNewWashington()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_washington'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_washington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(NewWashington::class));
    }
}
