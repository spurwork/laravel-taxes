<?php

namespace Appleton\Taxes\Unit\Countries\US\California;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\California\CaliforniaIncome\CaliforniaIncome;
use Appleton\Taxes\Countries\US\California\CaliforniaUnemployment\CaliforniaUnemployment;
use Carbon\Carbon;
use TestCase;

class CaliforniaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testCaliforniaUnemploymentWithTaxRate(): void
    {
        config(['taxes.rates.us.california.unemployment' => 0.024]);

        $results = $this->calculateTaxes(2300, 0);
        $this->assertSame(55.20, $results->getTax(CaliforniaUnemployment::class));
    }

    public function testCaliforniaUnemploymentMetWageBase(): void
    {
        // not met 7000 wage base, all 100$ taxable at 3.4%
        $results = $this->calculateTaxes(100, 6900);
        $this->assertSame(3.4, $results->getTax(CaliforniaUnemployment::class));

        // will meet 7000 wage base, only 1$ taxable at 3.4%
        $results = $this->calculateTaxes(100, 6999);
        $this->assertSame(.03, $results->getTax(CaliforniaUnemployment::class));

        // already met 7000 wage base, none taxable
        $results = $this->calculateTaxes(100, 7000);
        $this->assertSame(0.0, $results->getTax(CaliforniaUnemployment::class));

        // already met 7000 wage base, none taxable
        $results = $this->calculateTaxes(100, 7001);
        $this->assertSame(0.0, $results->getTax(CaliforniaUnemployment::class));

        // already met 7000 wage base, none taxable
        $results = $this->calculateTaxes(100, 7100);
        $this->assertSame(0.0, $results->getTax(CaliforniaUnemployment::class));
    }

    public function testtestCaliforniaUnemploymentWorkOutOfState(): void
    {
        $results = $this->calculateTaxes(100, 6900, 'us.alabama');

        $this->assertNull($results->getTax(CaliforniaIncome::class));
        $this->assertSame(3.4, $results->getTax(CaliforniaUnemployment::class));
    }

    private function calculateTaxes(int $earnings, int $ytd_earnings,
                                    string $work_location = 'us.california'): TaxResults
    {
        return $this->taxes->calculate(function ($taxes) use ($earnings, $ytd_earnings, $work_location) {
            $taxes->setHomeLocation($this->getLocation('us.california'));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });
    }
}
