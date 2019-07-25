<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Woodstock\Woodstock;
use Carbon\Carbon;
use TestCase;

class WoodstockTest extends TestCase
{
    public function testWoodstock()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.woodstock'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.woodstock'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Woodstock::class));
    }
}
