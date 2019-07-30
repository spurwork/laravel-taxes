<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Conneaut\Conneaut;
use Carbon\Carbon;
use TestCase;

class ConneautTest extends TestCase
{
    public function testConneaut()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.conneaut'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.conneaut'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.95, $results->getTax(Conneaut::class));
    }
}
