<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Barberton\Barberton;
use Carbon\Carbon;
use TestCase;

class BarbertonTest extends TestCase
{
    public function testBarberton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.barberton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.barberton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(Barberton::class));
    }
}