<?php

namespace Appleton\Taxes\Unit\Countries\US\Indiana;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Indiana\IndianaUnemployment\IndianaUnemployment;
use Carbon\Carbon;
use TestCase;

class IndianaUnemploymentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    /**
     * Wages        $100.00
     * YTD Wages    $9,350.00
     * Taxes        $2.50
     *
     * Math:
     * 9500 - 9350 = 150 to get to wage base
     * only 100 in wages, all taxable
     * round(100.0 * .025) = 2.50;
     */
    public function testIndianaUnemployment_notMetWageBase(): void
    {
        $results = $this->calculateTaxes(100.0, 9350.0);
        $this->assertThat(2.50, self::identicalTo($results->getTax(IndianaUnemployment::class)));
    }

    /**
     * Wages        $200.00
     * YTD Wages    $9,400.00
     * Taxes        $2.50
     *
     * Math:
     * 9500 - 9400 = 100 to get to wage base
     * wages are over 100, only 100 taxable
     * round(100.0 * .02.5) = 2.50;
     */
    public function testIndianaUnemployment_metAndExceedWageBase(): void
    {
        $results = $this->calculateTaxes(200.0, 9400.0);
        $this->assertThat(2.50, self::identicalTo($results->getTax(IndianaUnemployment::class)));
    }
    
    /**
     * Wages        $100.00
     * YTD Wages    $9,600.00
     * Taxes        $0.00
     *
     * Math:
     * 9500 wage base already met, none taxable
     */
    public function testIndianaUnemployment_exceedWageBase(): void
    {
        $results = $this->calculateTaxes(100.0, 96000.0);
        $this->assertThat(0.0, self::identicalTo($results->getTax(IndianaUnemployment::class)));
    }

    private function calculateTaxes(float $earnings, float $ytd_earnings): TaxResults
    {
        return $this->taxes->calculate(function (Taxes $taxes) use ($earnings, $ytd_earnings) {
            $taxes->setHomeLocation($this->getLocation('us.indiana'));
            $taxes->setWorkLocation($this->getLocation('us.indiana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setYtdEarnings($ytd_earnings);
        });
    }
}