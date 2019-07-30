<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Groveport\Groveport;
use Carbon\Carbon;
use TestCase;

class GroveportTest extends TestCase
{
    public function testGroveport()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.groveport'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.groveport'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Groveport::class));
    }
}
