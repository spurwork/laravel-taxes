<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Springboro\Springboro;
use Carbon\Carbon;
use TestCase;

class SpringboroTest extends TestCase
{
    public function testSpringboro()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.springboro'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.springboro'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Springboro::class));
    }
}
