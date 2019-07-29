<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Archbold\Archbold;
use Carbon\Carbon;
use TestCase;

class ArchboldTest extends TestCase
{
    public function testArchbold()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.archbold'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.archbold'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Archbold::class));
    }
}
