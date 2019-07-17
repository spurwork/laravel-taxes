<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Ontario\Ontario;
use Carbon\Carbon;
use TestCase;

class OntarioTest extends TestCase
{
    public function testOntario()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.ontario'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.ontario'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Ontario::class));
    }
}
