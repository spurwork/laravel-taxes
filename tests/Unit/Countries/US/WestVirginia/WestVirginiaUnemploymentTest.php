<?php

namespace Appleton\Taxes\Unit\Countries\US\WestVirginia;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaIncome\WestVirginiaIncome;
use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaUnemployment\WestVirginiaUnemployment;
use Carbon\Carbon;
use TestCase;

class WestVirginiaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testWestVirginiaUnemploymentWithTaxRate(): void
    {
        config(['taxes.rates.us.west_virginia.unemployment' => 0.02]);

        $results = $this->calculateTaxes(100);
        $this->assertSame(2.0, $results->getTax(WestVirginiaUnemployment::class));
    }

    public function testWestVirginiaUnemploymentMetWageBase(): void
    {
        // not met 7000 wage base, all 100$ taxable at 2.7%
        $results = $this->calculateTaxes(100, 11900);
        $this->assertSame(2.7, $results->getTax(WestVirginiaUnemployment::class));

        // will meet 7000 wage base, only 1$ taxable at 2.7%
        $results = $this->calculateTaxes(100, 11999);
        $this->assertSame(.03, $results->getTax(WestVirginiaUnemployment::class));

        // already met 7000 wage base, none taxable
        $results = $this->calculateTaxes(100, 12000);
        $this->assertSame(0.0, $results->getTax(WestVirginiaUnemployment::class));

        // already met 7000 wage base, none taxable
        $results = $this->calculateTaxes(100, 12001);
        $this->assertSame(0.0, $results->getTax(WestVirginiaUnemployment::class));

        // already met 7000 wage base, none taxable
        $results = $this->calculateTaxes(100, 12100);
        $this->assertSame(0.0, $results->getTax(WestVirginiaUnemployment::class));
    }

    public function testWestVirginiaUnemploymentWorkOutOfState(): void
    {
        $results = $this->calculateTaxes(100, 0, 'us.alabama');

        $this->assertNull($results->getTax(WestVirginiaIncome::class));
        $this->assertSame(2.7, $results->getTax(WestVirginiaUnemployment::class));
    }

    private function calculateTaxes(int $earnings, int $ytd_earnings = 0,
                                    string $work_location = 'us.west_virginia'): TaxResults
    {
        return $this->taxes->calculate(function ($taxes) use ($earnings, $ytd_earnings, $work_location) {
            $taxes->setHomeLocation($this->getLocation('us.west_virginia'));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });
    }
}
