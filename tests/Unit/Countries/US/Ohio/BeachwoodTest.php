<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Beachwood\Beachwood;
use Carbon\Carbon;
use TestCase;

class BeachwoodTest extends TestCase
{
    public function testBeachwood()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.beachwood'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.beachwood'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Beachwood::class));
    }
}
