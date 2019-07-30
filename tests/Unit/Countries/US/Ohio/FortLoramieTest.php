<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\FortLoramie\FortLoramie;
use Carbon\Carbon;
use TestCase;

class FortLoramieTest extends TestCase
{
    public function testFortLoramie()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.fort_loramie'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.fort_loramie'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(FortLoramie::class));
    }
}
