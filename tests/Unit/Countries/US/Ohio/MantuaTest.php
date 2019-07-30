<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Mantua\Mantua;
use Carbon\Carbon;
use TestCase;

class MantuaTest extends TestCase
{
    public function testMantua()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mantua'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mantua'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Mantua::class));
    }
}
