<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Grafton\Grafton;
use Carbon\Carbon;
use TestCase;

class GraftonTest extends TestCase
{
    public function testGrafton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.grafton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.grafton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Grafton::class));
    }
}
