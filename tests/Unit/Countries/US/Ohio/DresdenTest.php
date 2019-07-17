<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Dresden\Dresden;
use Carbon\Carbon;
use TestCase;

class DresdenTest extends TestCase
{
    public function testDresden()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.dresden'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.dresden'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Dresden::class));
    }
}
