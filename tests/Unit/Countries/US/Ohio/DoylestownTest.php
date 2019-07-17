<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Doylestown\Doylestown;
use Carbon\Carbon;
use TestCase;

class DoylestownTest extends TestCase
{
    public function testDoylestown()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.doylestown'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.doylestown'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Doylestown::class));
    }
}
