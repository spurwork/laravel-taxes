<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Middlefield\Middlefield;
use Carbon\Carbon;
use TestCase;

class MiddlefieldTest extends TestCase
{
    public function testMiddlefield()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.middlefield'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.middlefield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(Middlefield::class));
    }
}
