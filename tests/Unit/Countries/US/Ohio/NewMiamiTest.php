<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewMiami\NewMiami;
use Carbon\Carbon;
use TestCase;

class NewMiamiTest extends TestCase
{
    public function testNewMiami()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_miami'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_miami'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(NewMiami::class));
    }
}
