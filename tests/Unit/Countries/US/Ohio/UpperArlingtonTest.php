<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\UpperArlington\UpperArlington;
use Carbon\Carbon;
use TestCase;

class UpperArlingtonTest extends TestCase
{
    public function testUpperArlington()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.upper_arlington'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.upper_arlington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.50, $results->getTax(UpperArlington::class));
    }
}
