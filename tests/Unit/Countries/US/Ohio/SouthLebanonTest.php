<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthLebanon\SouthLebanon;
use Carbon\Carbon;
use TestCase;

class SouthLebanonTest extends TestCase
{
    public function testSouthLebanon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_lebanon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_lebanon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(SouthLebanon::class));
    }
}
