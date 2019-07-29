<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Montpelier\Montpelier;
use Carbon\Carbon;
use TestCase;

class MontpelierTest extends TestCase
{
    public function testMontpelier()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.montpelier'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.montpelier'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.80, $results->getTax(Montpelier::class));
    }
}
