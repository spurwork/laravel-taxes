<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Strasburg\Strasburg;
use Carbon\Carbon;
use TestCase;

class StrasburgTest extends TestCase
{
    public function testStrasburg()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.strasburg'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.strasburg'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Strasburg::class));
    }
}
