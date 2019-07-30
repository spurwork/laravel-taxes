<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\ColumbusGrove\ColumbusGrove;
use Carbon\Carbon;
use TestCase;

class ColumbusGroveTest extends TestCase
{
    public function testColumbusGrove()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.columbus_grove'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.columbus_grove'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(ColumbusGrove::class));
    }
}
