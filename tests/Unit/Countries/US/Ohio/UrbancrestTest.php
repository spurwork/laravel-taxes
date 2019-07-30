<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Urbancrest\Urbancrest;
use Carbon\Carbon;
use TestCase;

class UrbancrestTest extends TestCase
{
    public function testUrbancrest()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.urbancrest'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.urbancrest'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Urbancrest::class));
    }
}
