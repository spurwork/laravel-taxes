<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Payne\Payne;
use Carbon\Carbon;
use TestCase;

class PayneTest extends TestCase
{
    public function testPayne()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.payne'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.payne'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Payne::class));
    }
}
