<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Empire\Empire;
use Carbon\Carbon;
use TestCase;

class EmpireTest extends TestCase
{
    public function testEmpire()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.empire'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.empire'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Empire::class));
    }
}
