<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Millbury\Millbury;
use Carbon\Carbon;
use TestCase;

class MillburyTest extends TestCase
{
    public function testMillbury()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.millbury'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.millbury'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Millbury::class));
    }
}
