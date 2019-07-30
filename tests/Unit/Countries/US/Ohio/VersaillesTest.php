<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Versailles\Versailles;
use Carbon\Carbon;
use TestCase;

class VersaillesTest extends TestCase
{
    public function testVersailles()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.versailles'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.versailles'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Versailles::class));
    }
}
