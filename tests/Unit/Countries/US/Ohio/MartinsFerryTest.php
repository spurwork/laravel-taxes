<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MartinsFerry\MartinsFerry;
use Carbon\Carbon;
use TestCase;

class MartinsFerryTest extends TestCase
{
    public function testMartinsFerry()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.martins_ferry'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.martins_ferry'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MartinsFerry::class));
    }
}
