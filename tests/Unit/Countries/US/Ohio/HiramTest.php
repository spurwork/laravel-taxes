<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Hiram\Hiram;
use Carbon\Carbon;
use TestCase;

class HiramTest extends TestCase
{
    public function testHiram()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.hiram'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.hiram'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(Hiram::class));
    }
}
