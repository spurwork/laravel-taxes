<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\StClairsville\StClairsville;
use Carbon\Carbon;
use TestCase;

class StClairsvilleTest extends TestCase
{
    public function testStClairsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.st_clairsville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.st_clairsville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(StClairsville::class));
    }
}
