<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\ShawneeHills\ShawneeHills;
use Carbon\Carbon;
use TestCase;

class ShawneeHillsTest extends TestCase
{
    public function testShawneeHills()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.shawnee_hills'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.shawnee_hills'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(ShawneeHills::class));
    }
}
