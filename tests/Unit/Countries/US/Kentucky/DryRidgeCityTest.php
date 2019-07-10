<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\DryRidgeCity\DryRidgeCity;
use Carbon\Carbon;
use TestCase;

class DryRidgeCityTest extends TestCase
{
    public function testDryRidgeCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.dry_ridge_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.dry_ridge_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(DryRidgeCity::class));
    }
}
