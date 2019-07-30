<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Bedford\Bedford;
use Carbon\Carbon;
use TestCase;

class BedfordTest extends TestCase
{
    public function testBedford()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.bedford'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.bedford'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(9.00, $results->getTax(Bedford::class));
    }
}
