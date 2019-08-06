<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\BrimfieldTallmadge\BrimfieldTallmadge;
use Carbon\Carbon;
use TestCase;

class BrimfieldTallmadgeTest extends TestCase
{
    public function testBrimfieldTallmadge()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([BrimfieldTallmadge::class]);
        });

        $this->assertSame(4.5, $results->getTax(BrimfieldTallmadge::class));
    }
}
