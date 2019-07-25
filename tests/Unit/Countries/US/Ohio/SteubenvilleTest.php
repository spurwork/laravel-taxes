<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Steubenville\Steubenville;
use Carbon\Carbon;
use TestCase;

class SteubenvilleTest extends TestCase
{
    public function testSteubenville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.steubenville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.steubenville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Steubenville::class));
    }
}
