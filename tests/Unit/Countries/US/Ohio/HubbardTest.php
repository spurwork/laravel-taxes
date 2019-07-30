<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Hubbard\Hubbard;
use Carbon\Carbon;
use TestCase;

class HubbardTest extends TestCase
{
    public function testHubbard()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.hubbard'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.hubbard'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Hubbard::class));
    }
}
