<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Ravenna\Ravenna;
use Carbon\Carbon;
use TestCase;

class RavennaTest extends TestCase
{
    public function testRavenna()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.ravenna'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.ravenna'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.50, $results->getTax(Ravenna::class));
    }
}
