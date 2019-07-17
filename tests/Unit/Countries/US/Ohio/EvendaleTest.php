<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Evendale\Evendale;
use Carbon\Carbon;
use TestCase;

class EvendaleTest extends TestCase
{
    public function testEvendale()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.evendale'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.evendale'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.60, $results->getTax(Evendale::class));
    }
}
