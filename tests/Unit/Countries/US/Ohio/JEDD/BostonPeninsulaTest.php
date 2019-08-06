<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\BostonPeninsula\BostonPeninsula;
use Carbon\Carbon;
use TestCase;

class BostonPeninsulaTest extends TestCase
{
    public function testBostonPeninsula()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([BostonPeninsula::class]);
        });

        $this->assertSame(6.0, $results->getTax(BostonPeninsula::class));
    }
}
