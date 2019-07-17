<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\PepperPike\PepperPike;
use Carbon\Carbon;
use TestCase;

class PepperPikeTest extends TestCase
{
    public function testPepperPike()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.pepper_pike'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.pepper_pike'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(PepperPike::class));
    }
}
