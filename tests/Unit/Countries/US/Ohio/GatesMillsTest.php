<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\GatesMills\GatesMills;
use Carbon\Carbon;
use TestCase;

class GatesMillsTest extends TestCase
{
    public function testGatesMills()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.gates_mills'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.gates_mills'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(GatesMills::class));
    }
}
