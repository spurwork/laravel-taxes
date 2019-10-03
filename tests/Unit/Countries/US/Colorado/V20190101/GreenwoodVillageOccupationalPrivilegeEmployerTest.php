<?php

namespace Appleton\Taxes\Unit\Countries\US\Colorado\V20190101;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilegeEmployer\GreenwoodVillageOccupationalPrivilegeEmployer;
use Carbon\Carbon;
use TestCase;

class GreenwoodVillageOccupationalPrivilegeEmployerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testGreenwoodVillageOccupationalPrivilege_no_local_wages(): void
    {
        $results = $this->calculateTaxes(0, 0, 30000, 0);
        $this->assertNull($results->getTax(GreenwoodVillageOccupationalPrivilegeEmployer::class));
    }

    public function testGreenwoodVillageOccupationalPrivilege_local_wages_already_taken(): void
    {
        $results = $this->calculateTaxes(10000, 30000, 10000, 30000);
        $this->assertNull($results->getTax(GreenwoodVillageOccupationalPrivilegeEmployer::class));
    }

    public function testGreenwoodVillageOccupationalPrivilege_local_wages_at_limit(): void
    {
        $results = $this->calculateTaxes(25000, 0, 25000, 0);
        $this->assertSame(2.0, $results->getTax(GreenwoodVillageOccupationalPrivilegeEmployer::class));
    }

    public function testGreenwoodVillageOccupationalPrivilege_local_wages_cross_limit(): void
    {
        $results = $this->calculateTaxes(30000, 0, 30000, 0);
        $this->assertSame(2.0, $results->getTax(GreenwoodVillageOccupationalPrivilegeEmployer::class));
    }

    public function testGreenwoodVillageOccupationalPrivilege_other_wages_at_limit(): void
    {
        $results = $this->calculateTaxes(0, 100, 15000, 100);
        $this->assertSame(2.0, $results->getTax(GreenwoodVillageOccupationalPrivilegeEmployer::class));
    }

    public function testGreenwoodVillageOccupationalPrivilege_other_wages_cross_limit(): void
    {
        $results = $this->calculateTaxes(0, 100, 20000, 100);
        $this->assertSame(2.0, $results->getTax(GreenwoodVillageOccupationalPrivilegeEmployer::class));
    }

    public function testGreenwoodVillageOccupationalPrivilege_local_wages_not_enough(): void
    {
        $results = $this->calculateTaxes(10000, 10000, 10000, 10000);
        $this->assertNull($results->getTax(GreenwoodVillageOccupationalPrivilegeEmployer::class));
    }

    private function calculateTaxes(
        int $local_earnings,
        int $previous_local_earnings,
        int $colorado_earnings,
        int $previous_colorado_earnings
    ): TaxResults {
        return $this->taxes->calculate(function ($taxes) use ($local_earnings, $previous_local_earnings, $colorado_earnings, $previous_colorado_earnings) {
            $taxes->setHomeLocation($this->getLocation('us.colorado'));
            $taxes->setWorkLocation($this->getLocation('us.colorado'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10000);
            $taxes->setPayPeriods(52);
            $taxes->setMtdEarnings(static function ($governmental_unit_area, $include_current) use ($local_earnings, $previous_local_earnings, $colorado_earnings, $previous_colorado_earnings) {
                if ($governmental_unit_area->name === 'Greenwood Village, CO') {
                    return $include_current ? $local_earnings + $previous_local_earnings : $previous_local_earnings;
                }

                if ($governmental_unit_area->name === 'Colorado') {
                    return $include_current ? $colorado_earnings + $previous_colorado_earnings : $previous_colorado_earnings;
                }

                return 0.0;
            });
        });
    }
}
