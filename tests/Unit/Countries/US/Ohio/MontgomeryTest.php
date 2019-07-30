<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Montgomery\Montgomery;
use Carbon\Carbon;
use TestCase;

class MontgomeryTest extends TestCase
{
    public function testMontgomery()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.montgomery'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.montgomery'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Montgomery::class));
    }
}
