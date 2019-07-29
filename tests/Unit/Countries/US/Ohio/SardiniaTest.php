<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Sardinia\Sardinia;
use Carbon\Carbon;
use TestCase;

class SardiniaTest extends TestCase
{
    public function testSardinia()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.sardinia'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.sardinia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Sardinia::class));
    }
}
