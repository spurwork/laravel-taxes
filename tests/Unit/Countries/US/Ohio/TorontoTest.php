<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Toronto\Toronto;
use Carbon\Carbon;
use TestCase;

class TorontoTest extends TestCase
{
    public function testToronto()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.toronto'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.toronto'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Toronto::class));
    }
}
