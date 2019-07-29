<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\GrandRiver\GrandRiver;
use Carbon\Carbon;
use TestCase;

class GrandRiverTest extends TestCase
{
    public function testGrandRiver()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.grand_river'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.grand_river'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(GrandRiver::class));
    }
}
