<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Georgetown\Georgetown;
use Carbon\Carbon;
use TestCase;

class GeorgetownTest extends TestCase
{
    public function testGeorgetown()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.georgetown'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.georgetown'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Georgetown::class));
    }
}
