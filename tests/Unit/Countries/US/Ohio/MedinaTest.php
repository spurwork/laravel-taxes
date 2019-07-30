<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Medina\Medina;
use Carbon\Carbon;
use TestCase;

class MedinaTest extends TestCase
{
    public function testMedina()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.medina'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.medina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(Medina::class));
    }
}
