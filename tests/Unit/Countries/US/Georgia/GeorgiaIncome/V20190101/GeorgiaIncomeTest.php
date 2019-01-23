<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20190101;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome as ParentGeorgiaIncome;
use Carbon\Carbon;

class GeorgiaIncomeTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testGeorgiaIncomeDaily()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.15, $results->getTax(ParentGeorgiaIncome::class));
    }

    public function testGeorgiaIncomeWeekly()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(680);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(30.69, $results->getTax(ParentGeorgiaIncome::class));
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

        $this->assertSame(0.0, $results->getTax(ParentGeorgiaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(12.15, $results->getTax(ParentGeorgiaIncome::class));
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

        $this->assertSame(2.00, $results->getTax(ParentGeorgiaIncome::class));
    }

    public function testGeorgiaIncomeNonNegative()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(9);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(ParentGeorgiaIncome::class));
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

        $this->assertSame(0.0, $results->getTax(ParentGeorgiaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.15, $results->getTax(ParentGeorgiaIncome::class));
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

        $this->assertSame(0.00, $results->getTax(ParentGeorgiaIncome::class));

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

        $this->assertSame(2.15, $results->getTax(ParentGeorgiaIncome::class));
    }

    public function testGeorgiaIncomeTestCase1()
    {
        FederalIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => 1,
            'filing_status' => FederalIncome::FILING_MARRIED,
        ]);

        GeorgiaIncomeTaxInformation::forUser($this->user)->update([
            'allowances' => 0,
            'personal_allowances' => 1,
            'filing_status' => ParentGeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
        ]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(412.5);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(9.44, $results->getTax(ParentGeorgiaIncome::class));
    }
}
