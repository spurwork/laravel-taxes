<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Crooksville\Crooksville;
use Carbon\Carbon;
use TestCase;

class CrooksvilleTest extends TestCase
{
    public function testCrooksville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.crooksville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.crooksville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Crooksville::class));
    }
}
