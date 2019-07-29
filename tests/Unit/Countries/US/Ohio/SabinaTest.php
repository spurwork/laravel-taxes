<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Sabina\Sabina;
use Carbon\Carbon;
use TestCase;

class SabinaTest extends TestCase
{
    public function testSabina()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.sabina'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.sabina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Sabina::class));
    }
}
