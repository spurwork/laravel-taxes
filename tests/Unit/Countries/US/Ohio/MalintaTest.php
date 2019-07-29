<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Malinta\Malinta;
use Carbon\Carbon;
use TestCase;

class MalintaTest extends TestCase
{
    public function testMalinta()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.malinta'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.malinta'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Malinta::class));
    }
}
