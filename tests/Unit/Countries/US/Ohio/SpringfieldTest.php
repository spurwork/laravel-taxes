<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Springfield\Springfield;
use Carbon\Carbon;
use TestCase;

class SpringfieldTest extends TestCase
{
    public function testSpringfield()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.springfield'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.springfield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.20, $results->getTax(Springfield::class));
    }
}
