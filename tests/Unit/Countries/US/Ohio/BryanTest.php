<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Bryan\Bryan;
use Carbon\Carbon;
use TestCase;

class BryanTest extends TestCase
{
    public function testBryan()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.bryan'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.bryan'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.40, $results->getTax(Bryan::class));
    }
}
