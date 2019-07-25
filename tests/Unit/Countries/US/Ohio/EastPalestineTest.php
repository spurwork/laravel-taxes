<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\EastPalestine\EastPalestine;
use Carbon\Carbon;
use TestCase;

class EastPalestineTest extends TestCase
{
    public function testEastPalestine()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.east_palestine'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.east_palestine'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(EastPalestine::class));
    }
}
