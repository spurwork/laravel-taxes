<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\GrandRapids\GrandRapids;
use Carbon\Carbon;
use TestCase;

class GrandRapidsTest extends TestCase
{
    public function testGrandRapids()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.grand_rapids'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.grand_rapids'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(GrandRapids::class));
    }
}
