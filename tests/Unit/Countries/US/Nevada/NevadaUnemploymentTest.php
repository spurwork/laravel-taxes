<?php

namespace Appleton\Taxes\Countries\US\Nevada\NevadaUnemployment;

use Appleton\Taxes\Classes\TaxResults;
use Carbon\Carbon;
use TestCase;

class NevadaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testNevadaUnemploymentWithTaxRate(): void
    {
        config(['taxes.rates.us.nevada.unemployment' => 0.02]);

        // all 100$ taxable at 2%
        $results = $this->calculateTaxes(100);
        $this->assertSame(2.0, $results->getTax(NevadaUnemployment::class));
    }

    public function testNevadaUnemployment(): void
    {
        // not met 31200 wage base, all 100$ taxable at 3%
        $results = $this->calculateTaxes(100, 31100);
        $this->assertSame(3.0, $results->getTax(NevadaUnemployment::class));

        // will meet 31200 wage base, only 1$ taxable at 3%
        $results = $this->calculateTaxes(100, 31199);
        $this->assertSame(.03, $results->getTax(NevadaUnemployment::class));

        // already met 31200 wage base, none taxable
        $results = $this->calculateTaxes(100, 31200);
        $this->assertSame(0.0, $results->getTax(NevadaUnemployment::class));

        // already met 31200 wage base, none taxable
        $results = $this->calculateTaxes(100, 31201);
        $this->assertSame(0.0, $results->getTax(NevadaUnemployment::class));

        // already met 31200 wage base, none taxable
        $results = $this->calculateTaxes(100, 31300);
        $this->assertSame(0.0, $results->getTax(NevadaUnemployment::class));
    }

    public function testWorkOutOfState(): void
    {
        $results = $this->calculateTaxes(100, 0, 'us.alabama');
        $this->assertSame(3.0, $results->getTax(NevadaUnemployment::class));
    }

    private function calculateTaxes(int $earnings, int $ytd_earnings = 0,
                                    string $work_location = 'us.nevada'): TaxResults
    {
        return $this->taxes->calculate(function ($taxes) use ($earnings, $ytd_earnings, $work_location) {
            $taxes->setHomeLocation($this->getLocation('us.nevada'));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });
    }
}
