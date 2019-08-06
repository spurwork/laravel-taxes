<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\SpringfieldAkron\SpringfieldAkron;
use Carbon\Carbon;
use TestCase;

class SpringfieldAkronTest extends TestCase
{
    public function testSpringfieldAkron()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([SpringfieldAkron::class]);
        });

        $this->assertSame(7.5, $results->getTax(SpringfieldAkron::class));
    }
}
