<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Tuscarawas\Tuscarawas;
use Carbon\Carbon;
use TestCase;

class TuscarawasTest extends TestCase
{
    public function testTuscarawas()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.tuscarawas'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.tuscarawas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Tuscarawas::class));
    }
}
