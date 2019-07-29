<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Octa\Octa;
use Carbon\Carbon;
use TestCase;

class OctaTest extends TestCase
{
    public function testOcta()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.octa'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.octa'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Octa::class));
    }
}
