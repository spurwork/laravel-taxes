<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Hebron\Hebron;
use Carbon\Carbon;
use TestCase;

class HebronTest extends TestCase
{
    public function testHebron()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.hebron'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.hebron'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Hebron::class));
    }
}
