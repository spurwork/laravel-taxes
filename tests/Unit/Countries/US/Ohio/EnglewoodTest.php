<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Englewood\Englewood;
use Carbon\Carbon;
use TestCase;

class EnglewoodTest extends TestCase
{
    public function testEnglewood()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.englewood'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.englewood'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Englewood::class));
    }
}
