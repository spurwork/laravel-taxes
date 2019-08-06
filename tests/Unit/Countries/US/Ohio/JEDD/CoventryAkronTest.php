<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\CoventryAkron\CoventryAkron;
use Carbon\Carbon;
use TestCase;

class CoventryAkronTest extends TestCase
{
    public function testCoventryAkron()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([CoventryAkron::class]);
        });

        $this->assertSame(7.5, $results->getTax(CoventryAkron::class));
    }
}
