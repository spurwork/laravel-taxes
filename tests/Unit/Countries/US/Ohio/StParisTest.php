<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\StParis\StParis;
use Carbon\Carbon;
use TestCase;

class StParisTest extends TestCase
{
    public function testStParis()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.st_paris'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.st_paris'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(StParis::class));
    }
}
