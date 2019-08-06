<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\MedinaMontville\MedinaMontville;
use Carbon\Carbon;
use TestCase;

class MedinaMontvilleTest extends TestCase
{
    public function testMedinaMontville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([MedinaMontville::class]);
        });

        $this->assertSame(3.75, $results->getTax(MedinaMontville::class));
    }
}
