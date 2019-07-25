<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\DeGraff\DeGraff;
use Carbon\Carbon;
use TestCase;

class DeGraffTest extends TestCase
{
    public function testDeGraff()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.de_graff'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.de_graff'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(DeGraff::class));
    }
}
