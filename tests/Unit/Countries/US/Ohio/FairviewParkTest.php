<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\FairviewPark\FairviewPark;
use Carbon\Carbon;
use TestCase;

class FairviewParkTest extends TestCase
{
    public function testFairviewPark()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.fairview_park'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.fairview_park'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(FairviewPark::class));
    }
}
