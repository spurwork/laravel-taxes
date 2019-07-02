<?php

namespace Appleton\Taxes\Unit\Countries\US\NewJersey;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\NewJerseyDisabilityInsurance;
use Carbon\Carbon;

class NewJerseyDisabilityInsuranceTest extends \TestCase
{
    public function testNewJerseyDisabilityInsurance()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(745);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.73, $results->getTax(NewJerseyDisabilityInsurance::class));
    }

    public function testNewJerseyDisabilityInsuranceOverWageBase()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(745);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(34401);
        });

        $this->assertSame(null, $results->getTax(NewJerseyDisabilityInsurance::class));
    }

    public function testNewJerseyDisabilityInsuranceJustUnderWageBase()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_jersey'));
            $taxes->setWorkLocation($this->getLocation('us.new_jersey'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(745);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(34399);
        });

        $this->assertSame(0.01, $results->getTax(NewJerseyDisabilityInsurance::class));
    }
}