<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkMetropolitanCommuterTransportationMobility;

use Carbon\Carbon;

class NewYorkMetropolitanCommuterTransportationMobilityTest extends \TestCase
{
    public function testNewYorkMetropolitanCommuterTransportationMobility()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings('1000');
        });

        $this->assertSame(3.40, $results->getTax(NewYorkMetropolitanCommuterTransportationMobility::class));
    }
}
