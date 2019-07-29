<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Loveland\Loveland;
use Carbon\Carbon;
use TestCase;

class LovelandTest extends TestCase
{
    public function testLoveland()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.loveland'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.loveland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Loveland::class));
    }
}
