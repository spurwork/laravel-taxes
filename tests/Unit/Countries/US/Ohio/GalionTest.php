<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Galion\Galion;
use Carbon\Carbon;
use TestCase;

class GalionTest extends TestCase
{
    public function testGalion()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.galion'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.galion'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Galion::class));
    }
}
