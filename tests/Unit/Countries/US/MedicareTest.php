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
            $taxes->setEarnings(2300);
            $taxes->setYtdEarnings(200000);
        });

        $this->assertSame(54.05, $results->getTax(Medicare::class));
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
}
