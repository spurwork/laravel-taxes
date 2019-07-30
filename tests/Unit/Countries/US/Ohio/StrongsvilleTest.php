<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Strongsville\Strongsville;
use Carbon\Carbon;
use TestCase;

class StrongsvilleTest extends TestCase
{
    public function testStrongsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.strongsville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.strongsville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Strongsville::class));
    }
}
