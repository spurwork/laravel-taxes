<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Elida\Elida;
use Carbon\Carbon;
use TestCase;

class ElidaTest extends TestCase
{
    public function testElida()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.elida'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.elida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(Elida::class));
    }
}
