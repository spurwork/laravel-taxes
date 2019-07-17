<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeave;

use Carbon\Carbon;
use Exception;

class MassachusettsFamilyMedicalLeaveTest extends \TestCase
{
    public function testMassachusettsFamilyMedicalLeave_tooEarly()
    {
        Carbon::setTestNow('2019-09-30');

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertNull($results->getTax(MassachusettsFamilyMedicalLeave::class));
    }

    public function testMassachusettsFamilyMedicalLeave()
    {
        Carbon::setTestNow('2019-10-01');

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(8.69, $results->getTax(MassachusettsFamilyMedicalLeave::class));
    }
}
