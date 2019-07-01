<?php

namespace Appleton\Taxes\Unit\Countries\US\Illinois;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Illinois\IllinoisUnemployment\IllinoisUnemployment;
use Carbon\Carbon;
use TestCase;

class IllinoisUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Wages        $1,000.00
     * Taxes        $31.75
     *
     * Math:
     * 12960 wage base not met, all taxable
     * round(1000.0 * .03175, 2) = 31.75;
     */
    public function testIllinoisUnemployment_noYtd(): void
    {
        $results = $this->calculateTaxes(1000.00, 0);
        $this->assertThat(31.75, self::identicalTo($results->getTax(IllinoisUnemployment::class)));
    }

    /**
     * Wages        $100.00
     * YTD Wages    $12,850.00
     * Taxes        $3.18
     *
     * Math:
     * 12850 + 100 = 12950
     * 12960 wage base not met, all taxable
     * round(100.0 * .03175, 2) = 3.18;
     */
    public function testIllinoisUnemployment_notMetWageBase(): void
    {
        $results = $this->calculateTaxes(100.0, 12850.0);
        $this->assertThat(3.18, self::identicalTo($results->getTax(IllinoisUnemployment::class)));
    }

    /**
     * Wages        $200.00
     * YTD Wages    $12,860.00
     * Taxes        $3.18
     *
     * Math:
     * 12860 + 200 = 13860
     * 12960 wage base met, 100 to get to 12960 taxable
     * round(100.0 * .03175, 2) = 3.18;
     */
    public function testIllinoisUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->calculateTaxes(200.0, 12860.0);
        $this->assertThat(3.18, self::identicalTo($results->getTax(IllinoisUnemployment::class)));
    }

    /**
     * Wages        $100.00
     * YTD Wages    $13,000.00
     * Taxes        $0.00
     *
     * Math:
     * 13000 wage base met, none taxable
     */
    public function testIllinoisUnemployment_exceedWageBase(): void
    {
        $results = $this->calculateTaxes(100.0, 13000.0);
        $this->assertThat(null, self::identicalTo($results->getTax(IllinoisUnemployment::class)));
    }

    private function calculateTaxes(float $earnings, float $ytd_earnings): TaxResults
    {
        return $this->taxes->calculate(function (Taxes $taxes) use ($earnings, $ytd_earnings) {
            $taxes->setHomeLocation($this->getLocation('us.illinois'));
            $taxes->setWorkLocation($this->getLocation('us.illinois'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });
    }
}
