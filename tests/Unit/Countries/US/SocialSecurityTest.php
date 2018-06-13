<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity;

class SocialSecurityTest extends \TestCase
{
    public function testSocialSecurity()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(142.60, $results->getTax(SocialSecurity::class));
    }

    public function testSocialSecurityEmployer()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(142.60, $results->getTax(SocialSecurityEmployer::class));
    }

    public function testSocialSecurityMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(127100);
        });

        $this->assertSame(6.20, $results->getTax(SocialSecurity::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(127150);
        });

        $this->assertSame(3.10, $results->getTax(SocialSecurity::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(127200);
        });

        $this->assertSame(0.0, $results->getTax(SocialSecurity::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(127250);
        });

        $this->assertSame(0.0, $results->getTax(SocialSecurity::class));
    }

    public function testCaseStudy1()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(4.13, $results->getTax(SocialSecurity::class));
    }

    // 2018

    public function testCaseStudy2018A()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(640);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(39.68, $results->getTax(SocialSecurity::class));
        $this->assertSame(39.68, $results->getTax(SocialSecurityEmployer::class));
    }

    public function testCaseStudy2018B()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(774.28);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(48.01, $results->getTax(SocialSecurity::class));
        $this->assertSame(48.01, $results->getTax(SocialSecurityEmployer::class));
    }

    public function testCaseStudy2018C()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(640);
            $taxes->setYtdEarnings(128500);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(SocialSecurity::class));
        $this->assertSame(0.0, $results->getTax(SocialSecurityEmployer::class));
    }

    public function testCaseStudy2018D()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(774.28);
            $taxes->setYtdEarnings(128500);
            $taxes->setDate($this->date('2018-01-01'));
        });

        $this->assertSame(0.0, $results->getTax(SocialSecurity::class));
        $this->assertSame(0.0, $results->getTax(SocialSecurityEmployer::class));
    }
}
