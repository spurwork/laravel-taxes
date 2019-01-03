<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome;

use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;
use Carbon\Carbon;

class NorthCarolinaIncomeTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testNorthCarolinaIncome()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(1.81, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testNorthCarolinaAdditionalWithholding()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update(['additional_withholding' => 10]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(0);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(NorthCarolinaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(11.81, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testNorthCarolinaSupplemental()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setSupplementalEarnings(100);
        });

        $this->assertSame(5.59, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testNorthCarolinaIncomeNonNegative()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.00, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testNorthCarolinaIncomeUseDefault()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->delete();

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(0);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(NorthCarolinaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(1.81, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testNorthCarolinaIncomeWorkInTennessee()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(1.81, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testCaseStudy2019A()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(270.00);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(7340.50);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertEquals(4.00, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testCaseStudy2019B()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 3,
            'filing_status' => NorthCarolinaIncome::FILING_MARRIED,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(785.00);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(17845.00);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertEquals(24.00, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testCaseStudy2019C()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_MARRIED,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(160.80);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(255.00);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertEquals(0.00, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testCaseStudy2019D()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 15.00,
            'dependents' => 5,
            'filing_status' => NorthCarolinaIncome::FILING_MARRIED,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(280.00);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(0.00);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertEquals(15.00, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testCaseStudy2019E()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 25.00,
            'dependents' => 1,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(455.00);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(5432.12);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertEquals(36.00, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testCaseStudy2019F()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_MARRIED,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(365.00);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(10432.12);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertEquals(36.00, $results->getTax(NorthCarolinaIncome::class));
    }

    public function testCaseStudy2019G()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 8,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(625.00);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(20000.00);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertEquals(36.00, $results->getTax(NorthCarolinaIncome::class));
    }
}
