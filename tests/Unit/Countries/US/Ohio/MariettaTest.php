<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Marietta\Marietta;
use Carbon\Carbon;
use TestCase;

class MariettaTest extends TestCase
{
    public function testMarietta()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.marietta'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.marietta'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.55, $results->getTax(Marietta::class));
    }
}
