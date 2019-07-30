<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Norwalk\Norwalk;
use Carbon\Carbon;
use TestCase;

class NorwalkTest extends TestCase
{
    public function testNorwalk()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.norwalk'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.norwalk'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Norwalk::class));
    }
}
