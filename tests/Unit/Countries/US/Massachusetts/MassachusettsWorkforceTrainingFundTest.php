<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsWorkforceTrainingFund;

use Carbon\Carbon;

class MassachusettsWorkforceTrainingFundTest extends \TestCase
{
    public function testMassachusettsWorkforceTrainingFund()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(1.29, $results->getTax(MassachusettsWorkforceTrainingFund::class));
    }

    public function testMassachusettsWorkforceTrainingFundMetWageBase()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(14900);
        });

        $this->assertSame(0.06, $results->getTax(MassachusettsWorkforceTrainingFund::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(14950);
        });

        $this->assertSame(0.03, $results->getTax(MassachusettsWorkforceTrainingFund::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(15000);
        });

        $this->assertSame(0.0, $results->getTax(MassachusettsWorkforceTrainingFund::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(15050);
        });

        $this->assertSame(0.0, $results->getTax(MassachusettsWorkforceTrainingFund::class));
    }
}
