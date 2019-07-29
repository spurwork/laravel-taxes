<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Williamsport\Williamsport;
use Carbon\Carbon;
use TestCase;

class WilliamsportTest extends TestCase
{
    public function testWilliamsport()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.williamsport'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.williamsport'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.50, $results->getTax(Williamsport::class));
    }
}
