<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Centerburg\Centerburg;
use Carbon\Carbon;
use TestCase;

class CenterburgTest extends TestCase
{
    public function testCenterburg()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.centerburg'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.centerburg'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Centerburg::class));
    }
}
