<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Amberley\Amberley;
use Carbon\Carbon;
use TestCase;

class AmberleyTest extends TestCase
{
    public function testAmberley()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.amberley'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.amberley'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Amberley::class));
    }
}
