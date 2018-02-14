<?php

namespace Appleton\Taxes\Countries\US\Medicare;

class MedicareTest extends \TestCase
{
    public function testMedicare()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(33.35, $results->getTax(Medicare::class));
    }

    public function testMedicareWithAdditionalTax()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(0);
        });

        $this->assertSame(1.45, $results->getTax(Medicare::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(199950);
        });

        $this->assertSame(1.90, $results->getTax(Medicare::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(200000);
        });

        $this->assertSame(2.35, $results->getTax(Medicare::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(200050);
        });

        $this->assertSame(2.35, $results->getTax(Medicare::class));
    }

    public function testMedicareEmployer()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
            $taxes->setYtdEarnings(200000);
        });

        $this->assertSame(33.35, $results->getTax(MedicareEmployer::class));
    }

    public function testCaseStudy1()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(0.97, $results->getTax(Medicare::class));
    }

    // 2018

    public function testCaseStudyA()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(271.67);
            $taxes->setYtdEarnings(24897.33);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(3.94, $results->getTax(Medicare::class));
        $this->assertSame(3.94, $results->getTax(MedicareEmployer::class));
    }

    public function testCaseStudyB()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(765.12);
            $taxes->setYtdEarnings(200100);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(17.98, $results->getTax(Medicare::class));
        $this->assertSame(11.09, $results->getTax(MedicareEmployer::class));
    }
}
