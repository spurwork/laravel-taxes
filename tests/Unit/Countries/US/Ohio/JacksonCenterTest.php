<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\JacksonCenter\JacksonCenter;
use Carbon\Carbon;
use TestCase;

class JacksonCenterTest extends TestCase
{
    public function testJacksonCenter()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.jackson_center'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.jackson_center'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(JacksonCenter::class));
    }
}
