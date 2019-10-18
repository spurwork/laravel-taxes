<?php

namespace Appleton\Taxes\Unit\Countries\US\Kansas;

use Appleton\Taxes\Classes\WorkerTaxes\TaxResults;
use Appleton\Taxes\Countries\US\Kansas\KansasUnemployment\KansasUnemployment;
use Carbon\Carbon;
use TestCase;

class KansasUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2019-01-01');
    }

    public function testKansasUnemployment(): void
    {
        $results = $this->calculateTaxes(5000);
        $this->assertSame(135.00, $results->getTax(KansasUnemployment::class));
    }

    public function testKansasUnemployment_not_met_wage_base(): void
    {
        $results = $this->calculateTaxes(3999, 10000);
        $this->assertSame(107.97, $results->getTax(KansasUnemployment::class));
    }

    public function testKansasUnemployment_meet_wage_base(): void
    {
        $results = $this->calculateTaxes(4000, 10000);
        $this->assertSame(108.00, $results->getTax(KansasUnemployment::class));
    }

    public function testKansasUnemployment_exceed_wage_base(): void
    {
        $results = $this->calculateTaxes(4001, 10000);
        $this->assertSame(108.00, $results->getTax(KansasUnemployment::class));
    }

    public function testKansasUnemployment_with_tax_rate(): void
    {
        config(['taxes.rates.us.kansas.unemployment' => 0.025]);

        $results = $this->calculateTaxes(14001);
        $this->assertSame(350.00, $results->getTax(KansasUnemployment::class));
    }

    public function testKansasUnemployment_work_out_of_state(): void
    {
        $results = $this->calculateTaxes(14001, 0, 'us.alabama');
        $this->assertSame(378.00, $results->getTax(KansasUnemployment::class));
    }

    private function calculateTaxes(int $earnings, int $ytd_earnings = 0,
                                    string $work_location = 'us.kansas'): TaxResults
    {
        return $this->taxes->calculate(function ($taxes) use ($earnings, $ytd_earnings, $work_location) {
            $taxes->setHomeLocation($this->getLocation('us.kansas'));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setYtdEarnings($ytd_earnings);
            $taxes->setEarnings($earnings);
        });
    }
}
