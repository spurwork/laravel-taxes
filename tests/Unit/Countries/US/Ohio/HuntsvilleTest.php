<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Huntsville\Huntsville;
use Carbon\Carbon;
use TestCase;

class HuntsvilleTest extends TestCase
{
    public function testHuntsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.huntsville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.huntsville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Huntsville::class));
    }
}
