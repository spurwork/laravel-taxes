<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Phillipsburg\Phillipsburg;
use Carbon\Carbon;
use TestCase;

class PhillipsburgTest extends TestCase
{
    public function testPhillipsburg()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.phillipsburg'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.phillipsburg'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Phillipsburg::class));
    }
}
