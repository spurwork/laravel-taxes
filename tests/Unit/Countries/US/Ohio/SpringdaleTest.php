<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Springdale\Springdale;
use Carbon\Carbon;
use TestCase;

class SpringdaleTest extends TestCase
{
    public function testSpringdale()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.springdale'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.springdale'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Springdale::class));
    }
}
