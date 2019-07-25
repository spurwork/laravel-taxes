<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewFranklin\NewFranklin;
use Carbon\Carbon;
use TestCase;

class NewFranklinTest extends TestCase
{
    public function testNewFranklin()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_franklin'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_franklin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(NewFranklin::class));
    }
}
