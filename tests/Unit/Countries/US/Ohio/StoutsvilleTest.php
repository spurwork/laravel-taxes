<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Stoutsville\Stoutsville;
use Carbon\Carbon;
use TestCase;

class StoutsvilleTest extends TestCase
{
    public function testStoutsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.stoutsville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.stoutsville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Stoutsville::class));
    }
}
