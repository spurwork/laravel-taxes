<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome;

use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Carbon\Carbon;

class GeorgiaIncomeTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testGeorgiaIncome()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.21, $results->getTax(GeorgiaIncome::class));
    }

    public function testGeorgiaAdditionalWithholding()
    {
        GeorgiaIncomeTaxInformation::forUser($this->user)->update(['additional_withholding' => 10]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(0);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(GeorgiaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(12.21, $results->getTax(GeorgiaIncome::class));
    }

    public function testGeorgiaSupplemental()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setSupplementalEarnings(100);
        });

        $this->assertSame(2.00, $results->getTax(GeorgiaIncome::class));
    }

    public function testGeorgiaIncomeNonNegative()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(GeorgiaIncome::class));
    }

    public function testGeorgiaIncomeUseDefault()
    {
        GeorgiaIncomeTaxInformation::forUser($this->user)->delete();

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(0);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(GeorgiaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.21, $results->getTax(GeorgiaIncome::class));
    }

    public function testGeorgiaIncomeClaimExempt()
    {
        $georgia_income_tax_information = GeorgiaIncomeTaxInformation::forUser($this->user);
        $georgia_income_tax_information->update([
            'exempt' => true
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.00, $results->getTax(GeorgiaIncome::class));

        $georgia_income_tax_information->update([
            'exempt' => false
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.74, $results->getTax(GeorgiaIncome::class));
    }

}
