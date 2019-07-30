<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Marshallville\Marshallville;
use Carbon\Carbon;
use TestCase;

class MarshallvilleTest extends TestCase
{
    public function testMarshallville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.marshallville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.marshallville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Marshallville::class));
    }
}
