<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Timberlake\Timberlake;
use Carbon\Carbon;
use TestCase;

class TimberlakeTest extends TestCase
{
    public function testTimberlake()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.timberlake'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.timberlake'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Timberlake::class));
    }
}
