<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeaveEmployer;

use Carbon\Carbon;
use Exception;

class MassachusettsFamilyMedicalLeaveEmployerTest extends \TestCase
{
    public function testMassachusettsFamilyMedicalLeaveEmployer()
    {
        Carbon::setTestNow('2019-10-01');

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(8.56, $results->getTax(MassachusettsFamilyMedicalLeaveEmployer::class));
    }
}
