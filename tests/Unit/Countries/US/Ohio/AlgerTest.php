<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Alger\Alger;
use Carbon\Carbon;
use TestCase;

class AlgerTest extends TestCase
{
    public function testAlger()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.alger'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.alger'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Alger::class));
    }
}
