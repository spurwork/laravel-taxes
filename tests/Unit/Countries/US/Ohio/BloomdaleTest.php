<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Bloomdale\Bloomdale;
use Carbon\Carbon;
use TestCase;

class BloomdaleTest extends TestCase
{
    public function testBloomdale()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.bloomdale'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.bloomdale'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Bloomdale::class));
    }
}
