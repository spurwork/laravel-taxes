<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\PleasantHill\PleasantHill;
use Carbon\Carbon;
use TestCase;

class PleasantHillTest extends TestCase
{
    public function testPleasantHill()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.pleasant_hill'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.pleasant_hill'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(PleasantHill::class));
    }
}
