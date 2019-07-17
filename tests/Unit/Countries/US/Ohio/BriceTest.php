<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Brice\Brice;
use Carbon\Carbon;
use TestCase;

class BriceTest extends TestCase
{
    public function testBrice()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.brice'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.brice'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Brice::class));
    }
}
