<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Beverly\Beverly;
use Carbon\Carbon;
use TestCase;

class BeverlyTest extends TestCase
{
    public function testBeverly()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.beverly'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.beverly'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Beverly::class));
    }
}
