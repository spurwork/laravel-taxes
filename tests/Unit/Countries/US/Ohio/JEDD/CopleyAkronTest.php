<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\CopleyAkron\CopleyAkron;
use Carbon\Carbon;
use TestCase;

class CopleyAkronTest extends TestCase
{
    public function testCopleyAkron()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([CopleyAkron::class]);
        });

        $this->assertSame(7.5, $results->getTax(CopleyAkron::class));
    }
}
