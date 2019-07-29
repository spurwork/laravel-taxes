<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\FairportHarbor\FairportHarbor;
use Carbon\Carbon;
use TestCase;

class FairportHarborTest extends TestCase
{
    public function testFairportHarbor()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.fairport_harbor'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.fairport_harbor'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(FairportHarbor::class));
    }
}
