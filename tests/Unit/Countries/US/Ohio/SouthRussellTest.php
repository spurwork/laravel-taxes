<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthRussell\SouthRussell;
use Carbon\Carbon;
use TestCase;

class SouthRussellTest extends TestCase
{
    public function testSouthRussell()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_russell'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_russell'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(SouthRussell::class));
    }
}
