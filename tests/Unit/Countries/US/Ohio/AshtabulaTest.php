<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Ashtabula\Ashtabula;
use Carbon\Carbon;
use TestCase;

class AshtabulaTest extends TestCase
{
    public function testAshtabula()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.ashtabula'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.ashtabula'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.40, $results->getTax(Ashtabula::class));
    }
}
