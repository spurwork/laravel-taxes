<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Utica\Utica;
use Carbon\Carbon;
use TestCase;

class UticaTest extends TestCase
{
    public function testUtica()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.utica'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.utica'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Utica::class));
    }
}
