<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\EastCleveland\EastCleveland;
use Carbon\Carbon;
use TestCase;

class EastClevelandTest extends TestCase
{
    public function testEastCleveland()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.east_cleveland'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.east_cleveland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(EastCleveland::class));
    }
}
