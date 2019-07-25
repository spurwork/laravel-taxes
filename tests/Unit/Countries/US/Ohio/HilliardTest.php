<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Hilliard\Hilliard;
use Carbon\Carbon;
use TestCase;

class HilliardTest extends TestCase
{
    public function testHilliard()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.hilliard'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.hilliard'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Hilliard::class));
    }
}
