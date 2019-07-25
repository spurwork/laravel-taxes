<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Roswell\Roswell;
use Carbon\Carbon;
use TestCase;

class RoswellTest extends TestCase
{
    public function testRoswell()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.roswell'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.roswell'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Roswell::class));
    }
}
