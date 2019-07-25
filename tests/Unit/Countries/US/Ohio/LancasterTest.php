<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Lancaster\Lancaster;
use Carbon\Carbon;
use TestCase;

class LancasterTest extends TestCase
{
    public function testLancaster()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lancaster'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lancaster'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Lancaster::class));
    }
}
