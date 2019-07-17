<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Galena\Galena;
use Carbon\Carbon;
use TestCase;

class GalenaTest extends TestCase
{
    public function testGalena()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.galena'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.galena'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Galena::class));
    }
}
