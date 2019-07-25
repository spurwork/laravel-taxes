<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Wadsworth\Wadsworth;
use Carbon\Carbon;
use TestCase;

class WadsworthTest extends TestCase
{
    public function testWadsworth()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.wadsworth'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.wadsworth'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.20, $results->getTax(Wadsworth::class));
    }
}
