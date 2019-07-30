<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Urbana\Urbana;
use Carbon\Carbon;
use TestCase;

class UrbanaTest extends TestCase
{
    public function testUrbana()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.urbana'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.urbana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.20, $results->getTax(Urbana::class));
    }
}
