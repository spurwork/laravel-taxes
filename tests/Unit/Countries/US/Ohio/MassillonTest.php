<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Massillon\Massillon;
use Carbon\Carbon;
use TestCase;

class MassillonTest extends TestCase
{
    public function testMassillon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.massillon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.massillon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Massillon::class));
    }
}
