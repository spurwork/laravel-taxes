<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Sandusky\Sandusky;
use Carbon\Carbon;
use TestCase;

class SanduskyTest extends TestCase
{
    public function testSandusky()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.sandusky'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.sandusky'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(Sandusky::class));
    }
}
