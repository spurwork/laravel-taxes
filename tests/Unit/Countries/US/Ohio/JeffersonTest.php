<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Jefferson\Jefferson;
use Carbon\Carbon;
use TestCase;

class JeffersonTest extends TestCase
{
    public function testJefferson()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.jefferson'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.jefferson'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Jefferson::class));
    }
}
