<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Woodlawn\Woodlawn;
use Carbon\Carbon;
use TestCase;

class WoodlawnTest extends TestCase
{
    public function testWoodlawn()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.woodlawn'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.woodlawn'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.90, $results->getTax(Woodlawn::class));
    }
}
