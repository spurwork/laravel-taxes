<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\VanWert\VanWert;
use Carbon\Carbon;
use TestCase;

class VanWertTest extends TestCase
{
    public function testVanWert()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.van_wert'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.van_wert'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.16, $results->getTax(VanWert::class));
    }
}
