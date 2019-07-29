<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Luckey\Luckey;
use Carbon\Carbon;
use TestCase;

class LuckeyTest extends TestCase
{
    public function testLuckey()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.luckey'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.luckey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Luckey::class));
    }
}
