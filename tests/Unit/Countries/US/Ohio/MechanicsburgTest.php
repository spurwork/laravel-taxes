<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Mechanicsburg\Mechanicsburg;
use Carbon\Carbon;
use TestCase;

class MechanicsburgTest extends TestCase
{
    public function testMechanicsburg()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mechanicsburg'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mechanicsburg'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Mechanicsburg::class));
    }
}
