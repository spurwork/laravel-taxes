<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome\V20190101;

use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome as ParentNorthCarolinaIncome;
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

    public function testCaseStudy2019A()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => ParentNorthCarolinaIncome::FILING_SINGLE,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(270.00);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(7340.5);
            $taxes->setDate($this->date('2019-01-01'));
        });

        $this->assertEquals(4.00, $results->getTax(ParentNorthCarolinaIncome::class));
    }

    public function testCaseStudy2019B()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 3,
            'filing_status' => ParentNorthCarolinaIncome::FILING_SINGLE,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(785.00);
            $taxes->setPayPeriods(52);
            $taxes->setYtdEarnings(17845);
            $taxes->setDate($this->date('2019-01-01'));
        });

        // spreadsheet has 24
        $this->assertEquals(29.00, $results->getTax(ParentNorthCarolinaIncome::class));
    }

    public function testCaseStudy2019C()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => ParentNorthCarolinaIncome::FILING_MARRIED,
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

        $this->assertEquals(0.00, $results->getTax(ParentNorthCarolinaIncome::class));
    }

    public function testCaseStudy2019D()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 15.00,
            'dependents' => 5,
            'filing_status' => ParentNorthCarolinaIncome::FILING_MARRIED,
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

        $this->assertEquals(15.00, $results->getTax(ParentNorthCarolinaIncome::class));
    }

    public function testCaseStudy2019E()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 25.00,
            'dependents' => 1,
            'filing_status' => ParentNorthCarolinaIncome::FILING_SINGLE,
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

        // spreadsheet has 36
        $this->assertEquals(37.00, $results->getTax(ParentNorthCarolinaIncome::class));
    }

    public function testCaseStudy2019F()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => ParentNorthCarolinaIncome::FILING_MARRIED,
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

        $this->assertEquals(9.00, $results->getTax(ParentNorthCarolinaIncome::class));
    }

    public function testCaseStudy2019G()
    {
        NorthCarolinaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'dependents' => 8,
            'filing_status' => ParentNorthCarolinaIncome::FILING_SINGLE,
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

        $this->assertEquals(11.00, $results->getTax(ParentNorthCarolinaIncome::class));
    }
}
