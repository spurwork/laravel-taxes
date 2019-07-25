<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Cridersville\Cridersville;
use Carbon\Carbon;
use TestCase;

class CridersvilleTest extends TestCase
{
    public function testCridersville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.cridersville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.cridersville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Cridersville::class));
    }
}
