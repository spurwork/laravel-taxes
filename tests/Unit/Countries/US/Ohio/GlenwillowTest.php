<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Glenwillow\Glenwillow;
use Carbon\Carbon;
use TestCase;

class GlenwillowTest extends TestCase
{
    public function testGlenwillow()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.glenwillow'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.glenwillow'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Glenwillow::class));
    }
}
