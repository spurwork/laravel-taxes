<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeaveEmployer;

use Carbon\Carbon;

class MassachusettsFamilyMedicalLeaveEmployerTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testMassachusettsFamilyMedicalLeaveEmployer()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(7.18, $results->getTax(MassachusettsFamilyMedicalLeaveEmployer::class));
    }
}
