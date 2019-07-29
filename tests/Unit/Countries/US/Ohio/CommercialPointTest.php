<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\CommercialPoint\CommercialPoint;
use Carbon\Carbon;
use TestCase;

class CommercialPointTest extends TestCase
{
    public function testCommercialPoint()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.commercial_point'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.commercial_point'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(CommercialPoint::class));
    }
}
