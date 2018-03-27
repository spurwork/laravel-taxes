<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome;

use Appleton\Taxes\Classes\Taxes;
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
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(2.74, $results->getTax(GeorgiaIncome::class));
    }

    public function testGeorgiaAdditionalWithholding()
    {
        GeorgiaIncomeTaxInformation::forUser($this->user)->update(['additional_withholding' => 10]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(0);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.0, $results->getTax(GeorgiaIncome::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(12.74, $results->getTax(GeorgiaIncome::class));
    }

    public function testGeorgiaSupplemental()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setSupplementalEarnings(100);
        });

        $this->assertSame(5.00, $results->getTax(GeorgiaIncome::class));
    }

    public function testGeorgiaIncomeNonNegative()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(0.01, $results->getTax(GeorgiaIncome::class));
    }
}
